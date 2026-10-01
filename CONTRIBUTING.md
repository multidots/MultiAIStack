# Contributing to MultiAIStack

Improvements are welcome, especially from teams running this against real WordPress VIP workloads.

## Ground rules

- **The contract is code.** Changes to `AGENTS.md`, the digest, or any SKILL.md go through a pull request with a rationale: what drift or failure did you observe, and how does the wording change fix it?
- **Shorter beats longer.** Rules that agents never violate are candidates for removal. Rules that agents keep violating need firmer, shorter wording or a concrete good/bad example, not more paragraphs.
- **One skill, one specialist.** New skills need a distinct persona and a job no existing skill does. Extend an existing SKILL.md before proposing a new folder.
- **Templates must verify.** Any change to `lib/templates/` must leave a fresh `/wp-setup` run green: `composer install && composer check` passes with the example test.
- **Evidence over opinion.** For rule changes, include a short before/after: the prompt you gave the agent, and what it produced with the old vs new wording.

## Repo layout

- `AGENTS.md` - the full contract every skill loads
- `agents-digest/` - condensed 2KB version for rules-reading agents
- `skills/<name>/SKILL.md` - one specialist per folder
- `lib/templates/` - the toolchain `/wp-setup` installs into repos
- `setup`, `bin/` - installer and uninstaller

## Releasing

Bump `VERSION`, add a `CHANGELOG.md` entry, tag. The digest header carries the version; update it in the same commit.
