# Darede Sync

[![Build Status](https://travis-ci.org/vsmoraes/daredesync.svg)](https://travis-ci.org/vsmoraes/daredesync)
[![License](https://poser.pugx.org/vsmoraes/daredesync/license.svg)](https://packagist.org/packages/vsmoraes/daredesync)

Sync data from the Pipedrive into de local database

# Instalation

Compose is needed, see how to install it: [Install composer](https://getcomposer.org/doc/00-intro.md#locally)

```bash
git clone https://github.com/vsmoraes/daredesync.git
```

```bash
cd daredesync
composer install
```

# Usage

Show all available commands
```bash
php sync
```

Import data from Pipedrive
```bash
php sync sync:fromPipedrive
```
