# 💼 E-Invoice System with RSA Digital Signature

A simple and secure web-based invoice system built with **Laravel 12**, using **RSA cryptography** for digital signatures, PDF export, and QR code verification.

---

## 🚀 Features

- ✅ Create, update, and delete invoices
- 🔐 Sign invoice data using **RSA Private Key**
- 🧾 Generate **PDF** invoices with embedded signature QR Code
- 🔎 Verify authenticity via public key (server-side validation)
- 🌐 Accessible via local server or public using **Ngrok**
- 📦 Clean MVC structure, ready for extension or integration

---

## 🛠️ Requirements

- PHP >= 8.2  
- Composer  
- Laravel 12  
- MySQL / MariaDB  
- OpenSSL enabled  
- Node.js & npm (for asset build if needed)

---

## ⚙️ Installation

```bash
# 1. Clone the repository
git clone https://github.com/yourusername/e-invoice-rsa.git
cd e-invoice-rsa

# 2. Install dependencies
composer install

# 3. Copy and edit environment
cp .env.example .env
php artisan key:generate

# 4. Setup database
# Edit DB_ credentials in .env file, then:
php artisan migrate

# 5. Generate RSA key pair (if not yet)
php artisan rsa:generate

# 6. Serve locally
php artisan serve
```

---

## 🔐 RSA Key Generation

The system uses **asymmetric RSA encryption** (public/private key):

```bash
# Generate keys in storage/app/keys/
php artisan rsa:generate
```

To move the keys into your `base_path('keys/')`, manually copy them if needed:

```bash
mkdir keys
mv storage/app/keys/* keys/
```

You should now have:
- `keys/private.pem`
- `keys/public.pem`

---

## 🧪 Sample Usage

- Visit `/invoices` to list invoices
- Create a new invoice (auto-signed)
- Download the signed PDF
- Verify authenticity on `/invoices/{id}/verify`

---

## 🖨️ PDF with Signature and QR Code

Each PDF invoice includes:
- Invoice metadata (number, client, amount)
- RSA digital signature status (`Valid / Invalid`)
- QR Code for verification
- Signature hash (hidden or base64-embedded)

---

## 🌐 Access via Ngrok (optional)

To share the app online:

```bash
ngrok http 8000
```

You’ll get a public HTTPS URL like `https://abc123.ngrok.io` — shareable with clients to verify their invoice.

---

## 📂 Project Structure Overview

```
app/
├── Http/Controllers/InvoiceController.php
├── Services/RSAService.php
resources/views/invoices/
├── index.blade.php
├── create.blade.php
├── show.blade.php
├── pdf.blade.php
├── verify.blade.php
```

---

## 📌 Developer Notes

- Digital signing uses data concatenation of:
  ```
  number + client_name + amount (formatted 2 decimals)
  ```
- You can modify the signature logic in `generateDataForSigning()`
- PDF generated with `barryvdh/laravel-dompdf`
- QR Code generated with `simplesoftwareio/simple-qrcode`

---

## 📄 License

This project is open-source and available under the [MIT license](LICENSE).

---

## 👨‍💻 Credits

Developed by [Nova Nurachman](https://github.com/yourusername)  
Guided by ChatGPT — Laravel RSA integration assistant