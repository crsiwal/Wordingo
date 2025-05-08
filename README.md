
# 📝 Wordiqo

**Wordiqo** is a powerful, open-source blogging platform built with **PHP (CodeIgniter 4)** and **Tailwind CSS**. It features a clean, modern frontend and a fully-featured admin panel to manage posts, categories, tags, SEO, caching, AMP pages, and more.

> _Write. Publish. Scale. — The modern blogging solution for developers and creators._

---

## 🚀 Features

- ✍️ Full blog post management (CRUD)
- 🧩 Categories and tags with SEO-friendly URLs
- ⚡ Post caching for fast content delivery *(excluding views & sitemap)*
- 🗺️ Auto-generated Sitemap (XML)
- 📈 Post view tracking
- ⚙️ SEO-ready (title, description, keywords)
- 🌐 AMP pages for posts and categories
- 🖼️ Thumbnail and cover image support
- 📅 Scheduled publishing support
- 🔐 Admin panel with secure login
- 🎨 Tailwind CSS-based modern UI
- 🧰 Built on **CodeIgniter 4** – fast, secure, and modular

---

## 📦 Installation

> Make sure you have PHP 8+, Composer, and MySQL installed.

```bash
git clone https://github.com/crsiwal/wordiqo.git
cd wordiqo
composer install
cp .env.example .env
php spark key:generate
```

Then, configure your `.env` file with database details:

```
database.default.hostname = localhost
database.default.database = wordiqo
database.default.username = root
database.default.password = yourpassword
```

Run migrations:

```bash
php spark migrate
```

(Optional) Seed dummy content:

```bash
php spark db:seed DummySeeder
```

Serve the app:

```bash
php spark serve
```

Visit: `http://localhost:8080`

---

## 🔐 Admin Panel

- URL: `/admin`
- Default Login:
  - **Username:** `admin@example.com`
  - **Password:** `admin123` *(you can change it after login)*

---

## 🧠 Technologies Used

- [CodeIgniter 4](https://codeigniter.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [MySQL](https://www.mysql.com/)
- [Composer](https://getcomposer.org/)
- AMP HTML for mobile optimization

---

## 🗂️ Folder Structure

```
/app
    /Controllers
    /Models
    /Views
/public
/tailwind.config.js
```

---

## 💡 Contributing

Pull requests are welcome, but for major changes, please open an issue first to discuss what you would like to change.

---

## 📄 License

This project is licensed under the **MIT License** – see the [LICENSE](LICENSE) file for details.

---

## 🌐 Links

- 🌍 [Live Demo Coming Soon](#)
- 📘 [Documentation](docs/)
- 💬 [Community Discussions](https://github.com/crsiwal/wordiqo/discussions)

---

## 🙌 Credits

Crafted with ❤️ by [Rahul Siwal](https://github.com/crsiwal)
