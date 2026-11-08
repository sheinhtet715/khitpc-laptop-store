# KhitPC Laptop Store

A full-stack e-commerce web application engineered with PHP, Laravel, and MySQL, designed for browsing hardware catalogs, managing carts asynchronously, and handling real-time store administration.

**Live Deployment:** [https://hhs.heinhtetsankhitpcpj.shop/]

## Key Features
- **Relational Database Architecture:** Normalized SQL schema separating core commercial product entities from technical hardware specifications to optimize query performance and search filtering.
- **Dynamic Asynchronous Storefront:** Responsive, mobile-first frontend built with Bootstrap and custom CSS, utilizing Swiper.js, Typed.js, and an internal JSON API via `fetch()` for zero-reload cart updates.
- **Authentication & Security:** Secure credential storage using Bcrypt hashing alongside OAuth2 social logins via Laravel Socialite.
- **Administrative Control Panel:** Centralized dashboard for real-time inventory management, dynamic order status workflows, and payment receipt tracking.
- **External Integrations:** Formspree integration for contact handling and isolated SMTP testing via Mailtrap.

## Tech Stack

- **Backend:** PHP 8.2, Laravel Framework
- **Database:** MySQL / MariaDB
- **Frontend:** Blade, JavaScript (ES6+), Bootstrap, CSS3, HTML5
- **Testing & Tools:** Mailtrap, Formspree, Composer, Git
