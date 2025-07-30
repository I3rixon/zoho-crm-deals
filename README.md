# Zoho CRM Deal & Account Web Form (Vue.js + Laravel)

This project is a test development task for a job vacancy. It implements a simple web form that allows users to create both **Deals** and **Accounts** in **Zoho CRM**, using a frontend built with **Vue.js** and a backend powered by **Laravel**.

---

## 📝 Description

The main objective of this project is to demonstrate integration with the **Zoho CRM API** by:

- Creating a **web form** where users can input details to create a **Deal** and an **Account**.
- Submitting the data to the **Laravel backend**, which then communicates with **Zoho CRM** to create and link the records.
- Automatically handling **OAuth2 token refresh** to ensure that the access token remains valid and records can be created at any time.

This proof-of-concept focuses on clean architecture, separation of concerns, and secure API integration.

---

## 🔧 Technologies Used

- **Vue.js 3** – For the frontend form UI and interaction
- **Laravel 12** – As the backend API and integration layer
- **Zoho CRM API** – For creating and linking Deal and Account records
- **Vite** – Frontend bundler for fast builds
- **Axios** – For HTTP requests from Vue.js to Laravel



---

## 🔧 Requirements

- PHP >= 8.2
- Composer
- Node.js >= 18 (LTS recommended)
- npm

---

## 🚀 Installation

1. Clone the repository:

```bash
git clone https://github.com/i3rixon/zoho-crm-deals.git
cd zoho-crm-deals
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
php artisan serve