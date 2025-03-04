![License](https://img.shields.io/badge/License-MIT-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![Build Status](https://github.com/syedzaidi-magento/BusinessCart-B2C/actions/workflows/laravel.yml/badge.svg)
![Issues](https://img.shields.io/github/issues/syedzaidi-magento/BusinessCart-B2C)

# BusinessCart-B2C
A Laravel-based B2C e-commerce platform designed for flexibility and customization. This project is under active development, aiming to incorporate advanced e-commerce functionalities inspired by platforms like Magento.

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