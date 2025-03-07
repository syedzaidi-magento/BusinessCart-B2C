<div align="center">

<a href="http://localhost:8000" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none;">
<svg style="width: 2.5rem; height: auto;" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71 70" fill="none">
    <path fill="#008080" d="M2 1h69v70H2z"/>
    <path fill="#0098FB" d="M1.5 1v69.531C1.667 69.678 1.046 68.357 1.043 67.035.983 45.023 1 23.012 1.5 1z"/>
    <path fill="#373737" d="M61.016 25.549c-.267 1.149-.316 2.243-.832 2.547-7.115 4.203-14.294 8.297-21.37 12.367-4.374-12.285 7.308-12.522 12.949-17.917-4.209-2.411-8.074-4.815-12.136-6.82-1.01-.498-3.63-.486-5.143.313-7.199 3.802-14.123 8.121-21.322 11.923-2.423 1.31-3.11 2.854-3.046 5.49.183 7.493.064 14.994.064 22.491 0 7.134 1.014 8.369 8.409 10.037v-9.193c0-9.153-.165-18.307.136-27.445.061-1.864 1.429-4.321 2.968-5.377 4.095-2.81 8.567-5.092 12.993-7.385 1.149-.595 2.969-1.052 3.978-.554 4.063 2.005 7.928 4.409 12.137 6.82-5.641 5.396-17.323 5.632-12.949 17.917 7.076-4.07 14.255-8.164 21.37-12.367.516-.304.565-1.408.832-2.547z"/>
    <path fill="#909090" d="M45.19 64.213c-2.841 1.283-5.794 3.788-7.804 3.179-4.186-1.269-7.937-4.085-11.707-6.513-.695-.448-.878-2.065-.87-3.145.068-8.829-.061-17.659.007-26.486.084-5.382 4.676-5.507 8.524-8.115v9.458c0 9.554-.024 18.109.013 26.663.012 2.721-.948 6.295 2.807 7.025 2.201.428 4.922-.447 7.074-1.453 3.451-1.613 6.637-3.798 9.912-5.781 5.547-3.357 5.465-6.251 0.018-9.682-.416-.267-.954-.342-2.149-.75 2.714-1.735 4.279-2.908 5.992-3.795 3.688-1.91 7.838.51 8.113 4.63.823 12.311.82 12.305-10.076 18.432-3.191 1.794-6.359 3.629-9.854 5.633z"/>
</svg>
<span style="font-size: 1.5rem; font-weight: bold; color: #4A5568;">BusinessCart</span>
</a>

---

![License](https://img.shields.io/badge/License-MIT-blue.svg)
![BusinessCart](https://img.shields.io/badge/BusinessCart-1.x-teal.svg)
![Issues](https://img.shields.io/github/issues/syedzaidi-magento/BusinessCart-B2C)

</div>

# BusinessCart D2C
A PHP-based D2C e-commerce platform designed for flexibility and customization. This project is under active development, aiming to incorporate advanced e-commerce functionalities inspired by platforms like Magento.

## Table of Contents
- [Features](#features)
- [Missing Features](#missing-features)
- [Installation](#installation)
- [Getting Started](#getting-started)
- [Screenshots](#screenshots)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [License](#license)

## Features
- **User Authentication & Management**:
  - User registration, login, and logout.
  - Role-based access (`admin`, `customer`).
  - User address management (`shipping`, `billing`).
- **Product Management**:
  - Full CRUD for products.
  - Multiple product types (`simple`, `configurable`).
  - Product image uploads.
  - Custom attributes.
- **Cart Functionality**:
  - Add/remove products.
  - Basic persistence for logged-in users.
- **Order Management**:
  - Orders tied to `user_id`.
- **Admin Dashboard**:
  - Product CRUD with images.
  - User address management.

## Missing Features
The following features are planned for future development:
- **User Management**:
  - Customer groups and segmentation.
  - Wishlists.
  - Newsletter subscriptions.
- **Product/Catalog**:
  - Virtual and downloadable products.
  - Attribute sets.
  - Tier pricing.
- **Cart & Checkout**:
  - Guest checkout.
  - Cart rules (promotions).
  - Multi-step checkout.
- **Orders & Payments**:
  - Payment gateway integrations (e.g., Stripe).
  - Multi-currency support.
- **Shipping**:
  - Configurable shipping methods.

## Installation
To set up **BusinessCart-B2C** locally, follow these steps:

### Prerequisites
- **PHP**: Version 8.1 or higher.
- **Composer**: For PHP dependency management.
- **Node.js & NPM**: For front-end assets.
- **SQLite**: Default database (or configure MySQL/PostgreSQL).

### Steps
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/syedzaidi-magento/BusinessCart-B2C.git
   cd BusinessCart-B2C
   ```

2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript/CSS Dependencies**:
   ```bash
   npm install
   ```

4. **Configure Environment**:
   Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
   Generate an application key:
   ```bash
   php artisan key:generate
   ```

5. **Set Up Database**:
   Edit `.env` to configure your database (example uses SQLite):
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   ```
   Run migrations:
   ```bash
   php artisan migrate
   ```

6. **Compile Front-End Assets**:
   ```bash
   npm run dev
   ```

7. **Run the Application**:
   ```bash
   php artisan serve
   ```
   Visit [http://localhost:8000](http://localhost:8000) in your browser.

## Getting Started
- **Register a User**: Navigate to `/register` to create an account.
- **Add Products (Admin)**: Log in as an admin (role = 'admin') and go to `/admin/products`.
- **Manage Addresses**: Visit `/user/addresses` to add shipping and billing addresses.

## Screenshots
- **Product Listing**:
  ![Product Listing](public/Product_list.png)

- **Product Detail**:
  ![Product Listing](public/Product_show.png)


- **Admin Dashboard**:
  ![Admin Dashboard](public/Dashboard.png)

*Note: The screenshots actual images may not updated in this repository.*

## Roadmap
- **Short-term**:
  - Implement guest checkout.
  - Add Stripe payment integration.
- **Mid-term**:
  - Introduce product attribute sets.
  - Enable layered navigation.
- **Long-term**:
  - Integrate Elasticsearch for advanced search.
  - Add multi-currency and multi-language support.

## Contributing
We welcome contributions! To get started:

1. **Fork the repository**.
2. **Create a feature branch**:
   ```bash
   git checkout -b feature/YourFeature
   ```
3. **Commit your changes**:
   ```bash
   git commit -am 'Add YourFeature'
   ```
4. **Push to your branch**:
   ```bash
   git push origin feature/YourFeature
   ```
5. **Open a Pull Request**.

Please follow our code of conduct and ensure your code passes all tests.

## License
This project is licensed under the MIT License:
