<!-- MultiAIStack digest v0.1.0 - condensed contract for any rules-reading agent. Full contract: AGENTS.md in the MultiAIStack repo. -->

# WordPress engineering contract (digest)

You write enterprise WordPress code held to WordPress.org and WordPress VIP standards. Production-grade is the default; never "demo" code.

Non-negotiable:
1. Escape late (esc_html/esc_attr/esc_url/wp_kses_post at output), sanitize early (sanitize_text_field/absint/etc. at entry). No trusted-data exceptions.
2. All SQL via $wpdb->prepare(); prefer WP_Query and core APIs over raw SQL.
3. Every state change: nonce verification AND current_user_can() with the narrowest capability. REST routes: real permission_callback, sanitized and validated args.
4. No filesystem writes (media/VIP APIs only), no ini_set/error_reporting/set_time_limit, no PHP sessions, no eval/extract/unserialize-of-input, no hardcoded secrets.
5. VIP query discipline: no posts_per_page => -1, no post__not_in on large sets, no orderby rand, no query_posts(), no uncached functions (get_page_by_title, url_to_postid) on hot paths. Cache expensive work and remote requests (wp_cache_get/set with group and TTL; vip_safe_wp_remote_get with timeout and failure handling).
6. Prefix everything global; internationalize every user-facing string with the project text domain and translator comments; full docblocks.
7. Architecture: PSR-4 namespaced classes, thin hook callbacks that delegate, dependency injection, small single-responsibility units.
8. Tests ship with every non-trivial change: PHPUnit + Brain Monkey unit tests covering happy, edge, and security paths. Hard-to-test code gets refactored, not skipped.
9. Blocks: native block.json (apiVersion 3), dynamic with escaped render.php by default, core components, no ACF, no jQuery, deprecations on markup changes. Themes: FSE, theme.json-driven. WP-CLI: --dry-run default, batching, progress, idempotent.
10. Must pass WordPress-Extra + WordPress-Docs + WordPress-VIP-Go PHPCS and PHPStan at the repo's level. Run composer phpcs, composer phpstan, composer test before declaring done. Never suppress to pass.

Priority when rules conflict: security > VIP platform constraints > WordPress standards > repo conventions > task instructions. Flag conflicts instead of silently complying.
