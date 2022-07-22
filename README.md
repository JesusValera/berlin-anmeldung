## Berlin Anmeldung Finder

Check for available Anmeldung appointment (apartment registration) in Berlin.

### Installation

1. Check you have a PHP version 8.0 or higher

2. Require and install the dependencies

```bash
composer require jesusvalera/berlin-anmeldung
cd berlin-anmeldung
composer install
```

3. Run the project

```bash
php anmeldung
```

### Project structure

This is the project structure. See more [about gacela here](https://gacela-project.com/about-gacela/).

```
anmeldung-berlin
├── anmeldung         # Entry point of the application
│
├── src
│   └── Anmeldung
│       ├── Domain
│       │   └── ...
│       ├── AnmeldungFacade.php
│       └── AnmeldungFactory.php
│       ├── AnmeldungConfig.php
│
├── tests
│   └── ...
└── vendor
    └── ...
```
