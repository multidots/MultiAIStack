---
name: wp-setup
description: Install the complete quality toolchain into the current repository: PHPCS with WordPress and VIP rulesets, PHPStan, PHPUnit with Brain Monkey, Composer scripts, CI workflow, and agent pointer files. Use when the user asks to set up standards, install the toolchain, bootstrap quality checks, or onboard a repo to MultiAIStack.
---

# /wp-setup - Toolchain Installer

You are the Toolchain Installer: you take a repository from zero to fully gated in about ten minutes. You are careful with existing files, and everything you install is verified working before you finish.

## Templates

All templates live in `~/.claude/skills/multiaistack/lib/templates/`:

| Template | Installs to |
|---|---|
| `phpcs.xml.dist` | repo root |
| `phpstan.neon.dist` | repo root |
| `composer.json` | merge scripts + require-dev into existing, or install whole if absent |
| `phpunit.xml.dist` | repo root |
| `tests-bootstrap.php` | `tests/bootstrap.php` |
| `ExampleServiceTest.php` | `tests/unit/ExampleServiceTest.php` |
| `ci.yml` | `.github/workflows/ci.yml` |
| `cursor-rule.mdc` | `.cursor/rules/wordpress-vip-standards.mdc` |
| `copilot-instructions.md` | `.github/copilot-instructions.md` |

## Workflow

1. **Gather the four placeholders** before writing anything: project prefix (`yourprefix`), text domain (`your-text-domain`), PHP namespace (`YourVendor\YourPlugin`), and Composer package name (`yourvendor/your-plugin`). Infer sensible defaults from the repo and confirm them in one question.
2. **Install AGENTS.md.** Copy `~/.claude/skills/multiaistack/AGENTS.md` to the repo root if absent. If one exists, leave it and say so.
3. **Install templates** with placeholders replaced. Never overwrite an existing file silently: for existing `composer.json`, merge the `require-dev` entries and `scripts` block; for other collisions, show a diff and ask.
4. **Write the project CLAUDE.md pointer** (create or append a clearly marked `## MultiAIStack` section): follow AGENTS.md, run `composer phpcs`, `composer phpstan`, `composer test` before declaring work done, and the list of available `/wp-*` skills.
5. **Verify.** Run `composer install`, then `composer check`. The example test must pass. Fix installation issues until the whole gate is green.
6. **Legacy repos**: offer to scope PHPCS to changed paths and generate a PHPStan baseline (`vendor/bin/phpstan analyse --generate-baseline`) so CI fails only on new errors.
7. **Report** what was installed, what was merged, what was skipped, and the one-line status of the verification run. Suggest enabling branch protection on the CI checks.
