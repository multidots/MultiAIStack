# MultiAIStack

**Turn your AI coding agent into an enterprise WordPress engineering team.**

Ten specialists for Claude Code, Cursor, and GitHub Copilot that generate and review WordPress code to the standard a WordPress VIP reviewer would hold it to: WordPress.org coding standards, VIP platform rules, security best practices, and unit tests with every change. All Markdown, all open source, GPL licensed.

We are [Multidots](https://www.multidots.com), an enterprise WordPress agency and **WordPress VIP Gold Partner**. Our engineers build and maintain publishing platforms for enterprise clients where a missed escape or an uncached query on a hot path is a production incident. AI coding agents made our teams dramatically faster, and also made it dramatically easier to ship code that *looks* right while violating six platform rules. MultiAIStack is the system we built to close that gap, and we are open sourcing it because every WordPress team using AI agents has the same problem.

**Who this is for:**

- **WordPress engineers** using Claude Code, Cursor, or Copilot who want VIP-grade output by default
- **Agency and product engineering leads** who need AI-assisted code to pass review the first time
- **Teams heading to WordPress VIP** who want to catch platform violations before VIP's reviewers do

## How it works: three layers

A prompt alone fails predictably: engineers forget to paste it, agents drift in long sessions, and nothing verifies the output. MultiAIStack layers three defenses:

1. **The contract** (`AGENTS.md`): the full operating rules, loaded automatically in every session.
2. **Self-verification**: every skill runs the real tools (PHPCS with VIP sniffs, PHPStan, PHPUnit) on its own output before declaring work done.
3. **The CI gate**: `/wp-setup` installs a workflow so non-compliant code cannot merge, no matter who or what wrote it.

The contract raises the average. CI guarantees the minimum.

## Install - 30 seconds

**Requirements:** [Claude Code](https://docs.anthropic.com/en/docs/claude-code) (or Cursor / Copilot, see below), Git, Composer, PHP 8.1+.

Open Claude Code and paste this. Claude does the rest.

> Install MultiAIStack: run `git clone --depth 1 https://github.com/multidots/MultiAIStack.git ~/.claude/skills/multiaistack && cd ~/.claude/skills/multiaistack && ./setup` then confirm the skills are linked. Then ask me if I also want to wire the current project (`./setup --project`) so the contract and pointer files land in this repo.

To onboard a repository completely, run `/wp-setup` inside your agent afterwards. It installs the PHPCS + PHPStan + PHPUnit toolchain, the Composer scripts, the CI workflow, and verifies everything green.

**Cursor:** `./setup --project` writes an always-on rule to `.cursor/rules/`. **Copilot:** the same command writes `.github/copilot-instructions.md`. **Any other rules-reading agent:** copy the 2KB digest at [`agents-digest/multiaistack-AGENTS.md`](agents-digest/multiaistack-AGENTS.md) into whatever file your agent reads.

## Quick start

1. Install (30 seconds, above)
2. Open any WordPress repo and run `/wp-setup` to install the toolchain
3. Run `/wp-block` and ask for a block; watch it arrive with escaping, i18n, and tests
4. Run `/vip-review` on an existing branch; read the verdict
5. Run `/wp-ship` when you are ready for a PR

You will know within ten minutes whether this is for you.

## The specialists

| Skill | Your specialist | What they do |
| --- | --- | --- |
| `/wp-standards` | **Standards Enforcer** | Audits any diff or file against the full contract. Runs the real linters, reports Blocker / Required / Suggested with file and line, fixes on request. Never suppresses a rule to get to green. |
| `/wp-block` | **Block Engineer** | Native `block.json`-driven Gutenberg blocks. Dynamic by default, escaped render, core components, Interactivity API, deprecations handled, tests included. No ACF, no jQuery. |
| `/wp-plugin` | **Plugin Architect** | PSR-4 namespaced plugins with a composition root, thin hooks, dependency injection, clean activation and uninstall, and unit tests beside every class. |
| `/wp-theme` | **FSE Theme Builder** | Block themes driven by `theme.json` tokens. Templates, parts, patterns, style variations. Flags functionality that belongs in a plugin instead of the theme. |
| `/wp-cli` | **CLI Engineer** | WP-CLI commands safe for production data: `--dry-run` by default, batched queries, memory management between batches, progress bars, idempotent re-runs. |
| `/vip-review` | **VIP Code Reviewer** | Simulates a WordPress VIP review before the real one: uncached functions, unbounded queries, filesystem writes, cache correctness. Verdict: passes, passes with recommendations, or returned. |
| `/wp-security` | **Security Auditor** | Vector-by-vector audit: XSS, injection, CSRF, capability gaps, IDOR, SSRF, uploads, secrets. Fixes findings and writes a regression test for every one. |
| `/wp-test` | **Test Engineer** | Finds untested logic, refactors for testability where needed, and generates PHPUnit + Brain Monkey unit tests covering happy, edge, and security paths. |
| `/wp-ship` | **Release Engineer** | Runs every gate CI will run, fixes failures, walks the contract checklist against the final diff, and prepares scoped commits plus a PR description with security notes and test evidence. |
| `/wp-setup` | **Toolchain Installer** | Onboards a repo in ten minutes: PHPCS (WordPress-Extra + Docs + VIP-Go), PHPStan with the WordPress extension, PHPUnit + Brain Monkey with a passing example test, Composer scripts, CI workflow, agent pointer files. Legacy-safe with baselines. |

Every skill loads the same contract first, so ten specialists never disagree about the rules.

## The sprint

The skills run in the order real work runs:

**Onboard → Build → Audit → Test → Ship**

`/wp-setup` gives every other skill its tools. `/wp-block`, `/wp-plugin`, `/wp-theme`, and `/wp-cli` build under the contract. `/wp-standards`, `/vip-review`, and `/wp-security` audit what exists. `/wp-test` closes the coverage gaps they find. `/wp-ship` runs the whole gate and hands a reviewer a PR they can trust.

## What's in the contract

`AGENTS.md` is the full operating contract, and the part worth reading before anything else. The ten non-negotiables, in one breath: escape late and sanitize early; all SQL prepared; nonce plus capability on every state change; no filesystem writes or runtime config changes; native meta instead of ACF; remote requests cached with timeouts; everything internationalized; business logic in testable units; PHP 8.1+ passing WordPress-Extra, WordPress-Docs, and WordPress-VIP-Go sniffs plus PHPStan.

It also covers VIP query and caching discipline, security standards beyond the basics (REST and AJAX hardening, uploads, redirects, secrets), architecture rules, the testing charter, and per-surface rules for blocks, FSE themes, and WP-CLI. When rules conflict, priority is explicit: security, then VIP platform constraints, then WordPress standards, then repo conventions, then task instructions.

**Make it yours.** The contract encodes opinionated choices (FSE-first, No-ACF, PSR-4). Fork it, edit it, and treat it like code: version it, change it by pull request, give it one owner.

## Team mode

Commit the wiring into the repo so every teammate's agent follows the contract without individual setup:

```bash
cd your-repo
~/.claude/skills/multiaistack/setup --project
git add AGENTS.md CLAUDE.md .cursor .github
git commit -m "Adopt MultiAIStack engineering contract for AI-assisted work"
```

Then run `/wp-setup` once, commit the toolchain, and enable branch protection on the CI checks. From that point compliance does not depend on anyone remembering anything.

## Not on WordPress VIP?

Keep everything. The VIP rules are simply what performant, secure WordPress looks like at scale. If you want, swap the `WordPress-VIP-Go` ruleset for `WordPress-Extra` alone in `phpcs.xml.dist` and relax the VIP-specific helper functions; we would keep the rest exactly as-is.

## Uninstall

```bash
~/.claude/skills/multiaistack/bin/multiaistack-uninstall
```

Removes the skill links and the install directory. Files installed into your repos (the contract, toolchain, CI) are left in place on purpose; they are yours now.

## Repo layout

```
MultiAIStack/
├── AGENTS.md                  the full contract every skill loads
├── agents-digest/             2KB condensed contract for rules-reading agents
├── skills/<name>/SKILL.md     ten specialists
├── lib/templates/             the toolchain /wp-setup installs into repos
├── setup                      installer (global + --project wiring)
└── bin/multiaistack-uninstall
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md). The short version: the contract is code, evidence beats opinion, and rules agents never violate should be deleted.

---

Free, GPL-2.0-or-later, open source. Built and used daily by the engineering team at [Multidots](https://www.multidots.com). Fork it, adapt it to your team's standards, and ship WordPress you can trust.
