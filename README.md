<p align="center">
<a href="https://t.me/programcms"><img src="https://img.shields.io/badge/Chat-Telegram-blue.svg"></a>
<a href="http://join.slack.com/t/programcms/shared_invite/zt-1qbsdh8sw-_rFQJsEI4qAbdhorYz4RWQ"><img src="https://img.shields.io/badge/Chat-Slack-2EB67D.svg"></a>
</p>
<p align="center"><img src="https://raw.githubusercontent.com/elquchiri/programcms/master/public/images/programcms-logo.png"></p>

ProgramCMS provides you with a complete, trustworthy CMS & easy to use PHP Framework to build and deploy All kind of Web Sites.

Written in PHP, on top of Symfony, it makes it very easy to reuse, install or create new bundles to Improve your Application.

The Manager Bundle deliver & Maintain ProgramCms Bundles, so you can choose any kind of features and modules wich fit the best with your application's requirements to add to your Website with ease.

## Deployment
![](https://img.shields.io/github/last-commit/elquchiri/programcms?label=In%20Active%20Development)

Please note that ProgramCMS Project is under development

## Requirements

- Apache 2 or Nginx
- PHP 8.1
- MySQL 8
- Node
- Redis
- Composer 2
- Git
## Installation

To install ProgramCMS project run :

```bash
  git clone git@github.com:elquchiri/programcms.git
  composer install
  
  Edit .env file to match your database
  DATABASE_URL="mysql://root:@127.0.0.1:3306/programcms?serverVersion=8&charset=utf8mb4"
  
  php bin/pcms make:migration
  php bin/pcms doctrine:migrations:migrate
  php bin/pcms generate:statics
```


## Features & CMS Philosophy

- Strong Authentication and Roles System
- Improved Content Manager and Editor System
- Improved And Full Control Page Views
- Marketing System
- Modular / Extensible System
- Centralized Configuration System
- Multi Website / Language System
- ProgramCms Manager for Extensions
- Advanced Reporting System
- Strong Administration Dashboard
- Automatic Routing System based on Controller Path
- Themes System
- Layouts, Containers, Blocks and Templates Engine
- Aspect-Oriented Programming Style
- Data Based AI to process, generate and translate content

## Demo

Frontend Home Page

![image](public/images/frontend-demo.png)

Backend Demo
- Catalog Categories

![image](public/images/backend-category-demo.PNG)
- Central Configuration

![image](public/images/backend-config-demo.PNG)

## Contribution

- To contribute to ProgramCMS, please feel free to send PRs Requests on this repository.
- Please feel free to email me on [elquchiri@gmail.com](mailto:elquchiri@gmail.com) for suggestions
- Please Join our Channels on Slack & Telegram
   - http://join.slack.com/t/programcms/shared_invite/zt-1qbsdh8sw-_rFQJsEI4qAbdhorYz4RWQ
   - https://t.me/programcms

## Remarkable Changes

- 2022/12: First commit in the project
- 2023/06: Changing Project name from ElectroForums to ProgramCMS

## Donation

Your donation will help, Improve and Speed up productivity of The Amazing ProgramCMS.

[![Donate](https://img.shields.io/badge/Donate-Buymeacoffee-green.svg)](https://www.buymeacoffee.com/elquchiriw?new=1)
