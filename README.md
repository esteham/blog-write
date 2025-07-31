# 📝 Blog Write – Custom Blog Editor Plugin for WordPress

**Blog Write** is a lightweight and developer-friendly WordPress plugin that allows site admins and editors to create and manage blog posts directly from a custom interface. Designed for simplicity and speed, this plugin integrates seamlessly with your WordPress installation and enhances the content writing workflow.

---

## 🚀 Features

- ✅ Custom blog post submission form
- 🖊️ Rich text editor using WordPress's built-in `wp_editor()`
- 🧾 Title, content, excerpt, tags, and category input support
- 📁 Media upload support (optional)
- 🕵️ Role-based access control (Admin & Editor by default)
- 📜 Clean and secure code structure following WP standards

---

## 📦 Folder Structure

```bash
blog-write/
├── blog-write.php          # Main plugin file
├── includes/
│   └── form-handler.php    # Handles post submission logic
├── templates/
│   └── blog-form.php       # Form UI template
├── assets/
│   └── css/
│       └── style.css       # Optional styling
└── README.md
```
⚙️ Installation
🔌 Manual Install

    Clone or download this repository:
```bash
    git clone https://github.com/esteham/blog-write.git
```
    Upload the blog-write folder to your WordPress /wp-content/plugins/ directory.

    Go to your WordPress Admin → Plugins → Activate “Blog Write”.

🌐 From Admin Panel

    Download the ZIP of this repo.

    Go to WordPress Admin → Plugins → Add New → Upload Plugin.

    Choose the ZIP file and click Install, then Activate.

🧰 How to Use

    After activation, go to your WordPress Admin Dashboard.

    Navigate to Posts → Blog Write Form (or a custom page where the form is embedded).

    Fill in the blog title, content, category, etc.

    Click “Publish” to create the post.

    You can also embed the form on any page using a shortcode (if added):

[blog_write_form]

🔐 User Roles & Access

By default, only users with edit_posts capability (like Admins and Editors) can access and use the blog write form. This can be changed in the plugin settings or manually in the code.
📌 Requirements

    WordPress 5.5 or later

    PHP 7.2+

    MySQL 5.6+ or MariaDB

📤 Future Improvements (Planned)

Media upload support

Draft saving feature

Success/error alert UI

Frontend form shortcode

    Rich category & tag suggestion

🤝 Contributing

Have suggestions or want to improve the plugin?

    Fork this repo

    Create a feature branch

    Submit a pull request with clear description

🧑‍💻 Author

```bash
Esteham H. Zihad Ansari
📧 Email: estahamulhasan@gmail.com
🌐 GitHub: @esteham
📄 License
```
This project is licensed under the MIT License.

Feel free to use, modify, and share!