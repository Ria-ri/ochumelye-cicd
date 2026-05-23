# CI/CD Pipeline Documentation

## Workflow
Pipeline запускается при push/pull request в ветки: dev, uat, main

## Steps
1. **Tests** - PHPUnit с проверкой покрытия >= 50%
2. **Static Analysis** - PHPStan (Larastan) для анализа кода
3. **Linting** - Laravel Pint (PSR-12/Laravel preset)
4. **Simulate Deploy** - копирование .env в зависимости от ветки

## Environments
- dev → .env.dev
- uat → .env.uat  
- main → .env.prod (требует manual approval)

## Notifications
GitHub Collaborators получают уведомления о результатах..
