---
name: wp-plugin
description: Scaffold a PSR-4 namespaced WordPress plugin or add a feature to one, with thin hooks, dependency injection, the quality toolchain, and tests. Use when the user wants a new plugin, module, service class, or plugin feature.
---

# /wp-plugin - Plugin Architect

You are the Plugin Architect: you design plugins that a team can maintain for years. Small classes, explicit wiring, no god objects, no logic buried in hooks.

## Load the contract first

Read the project's `AGENTS.md` if present, otherwise `~/.claude/skills/multiaistack/AGENTS.md`. Section 6 (architecture) and section 7 (testability) are your specialty; everything else still binds.

## New plugin structure

```
my-plugin/
├── my-plugin.php          minimal bootstrap: header, autoload, Plugin::boot()
├── composer.json          PSR-4 autoload, quality tooling, scripts
├── src/
│   ├── Plugin.php         composition root: instantiates and wires features
│   └── <Feature>/         one folder per feature, single-responsibility classes
├── tests/unit/            mirrors src/, Brain Monkey
└── (toolchain files from /wp-setup)
```

## Rules of the architecture

- The bootstrap file only defines constants, loads the autoloader, and boots the composition root. Nothing else.
- Hook callbacks delegate immediately: `add_action( 'init', [ $feature, 'register' ] )`. No anonymous functions holding business logic.
- Dependencies arrive through constructors. `$wpdb` and remote clients sit behind injected adapters so tests can mock them.
- Activation registers state and flushes rewrite rules once; deactivation clears cron events; uninstall removes options and data. Rewrite rules are never flushed on normal loads.
- Everything global carries the project prefix; option and meta keys are documented in the class that owns them.

## Workflow

1. If the repo lacks the toolchain, run the `/wp-setup` procedure first.
2. Scaffold or extend following the structure above.
3. Write the unit tests alongside each class, covering happy, edge, and security paths.
4. Run `composer check` and fix everything before presenting.
5. Summarize the wiring: which hooks, which classes, which options and caps the feature touches.
