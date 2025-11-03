Of course\! Here is a professional, user-friendly `README.md` file for your `sndpbag/blog` package, written in English.

-----

# sndpbag/blog - A Laravel Blog Package 📝

[](https://www.google.com/search?q=https://packagist.org/packages/sndpbag/blog)
[](https://www.google.com/search?q=https://packagist.org/packages/sndpbag/blog)
[](https://opensource.org/licenses/MIT)

`sndpbag/blog` is a powerful and easy-to-use blog package built for Laravel applications. It is designed to work seamlessly with **[sndpbag/admin-panel](https://packagist.org/packages/sndpbag/admin-panel)**, providing you with a complete and feature-rich blog management system out of the box.

 \#\# ✨ Features

This package is packed with modern features to make your blogging experience fast, efficient, and enjoyable:

  - **✍️ Full Post Management:** A complete CRUD interface in the dashboard for creating, editing, and deleting blog posts.
  - **🗂️ Category System:** Manage categories to organize your posts effectively, complete with soft-delete (trash) functionality.
  - **🏷️ Tagging System:** Add relevant tags to posts for better organization, searchability, and SEO.
  - **👤 Multi-Author Support:** Built with Polymorphic Relationships, allowing any model (like `User`, `Member`, or `Admin`) to be an author.
  - **🖼️ Advanced Image Handling:**
      - Easy featured image uploads for each post.
      - Direct image uploads from within the rich-text editor for a smooth writing experience.
  - **📝 Powerful Rich-Text Editor:** A beautiful WYSIWYG editor that supports text formatting, links, tables, and media embeds to create stunning content.
  - **🚀 SEO Optimized:** Includes fields for Meta Title and Meta Description for each post to improve search engine rankings.
  - **📊 Built-in Analytics:** Automatically tracks view and like counts for each post.
  - **💬 Interactive Frontend:**
      - Clean and responsive designs for the blog list and single post pages.
      - AJAX-powered like system for real-time interaction.
      - A nested comment and reply system for user discussions.

 
Follow these steps to get started:

```markdown
## 🛠️ Installation

... (composer require steps) ...

**2. Publish Assets & Views:**

This package uses tags to let you publish only what you need.

* **Publish Config File:** (এটি `config/blog.php` ফাইলটি পাবলিশ করবে)
    ```bash
    php artisan vendor:publish --tag="blog-config"
    ```

* **Publish Views (Recommended):** (এটি `resources/views/vendor/blog` ফোল্ডারে ভিউ ফাইলগুলো পাবলিশ করবে)
    **এটি খুবই গুরুত্বপূর্ণ** যাতে আপনি আপনার ওয়েবসাইটের `layouts/main.blade.php` ফাইলের সাথে ডিজাইন মেলাতে পারেন।
    ```bash
    php artisan vendor:publish --tag="blog-views"
    ```

* **(Optional) Publish Assets:** (যদি আপনার কোনো CSS/JS ফাইল থাকে)
    ```bash
    php artisan vendor:publish --tag="blog-assets"
    ```

**2. Publish Assets:**

This command will publish the necessary migrations and configuration files to your project.

```bash
php artisan vendor:publish --provider="Sndpbag\Blog\Providers\BlogServiceProvider"
```

**3. Run Migrations:**

This will create the required tables for your blog (e.g., `blogs`, `blog_categories`, `comments`, etc.) in your database.

```bash
php artisan migrate
```

## ⚙️ Usage & Integration

This package is designed for integration with `sndpbag/admin-panel`. Follow these steps after installation.

### Add a Link to the Dashboard Sidebar

To add a "Blog" link to your admin panel's sidebar:

1.  If you haven't already, publish the `admin-panel` configuration file:

    ```bash
    php artisan vendor:publish --tag="admin-panel-config"
    ```

2.  Now, open the `config/admin-panel.php` file in your project and add the following entry to the `sidebar` array:

    ```php
    'sidebar' => [
        // ... your other menu items ...

        [
            'title' => 'Blog Posts',
            'route' => 'blog.index', // The route for the blog index
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>',
            'active_on' => 'blog.*' // The link will be active for all blog routes
        ],
        [
            'title' => 'Blog Categories',
            'route' => 'blog-categories.index',
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>',
            'active_on' => 'blog-categories.*'
        ],
        [
            'title' => 'Comments',
            'route' => 'comments.index', // কমেন্ট রুট
            'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
            'active_on' => 'comments.*' // 'comments' রুটে অ্যাক্টিভ থাকবে
        ],
    ]
    ```

### Accessing the Blog Section

You can now access the blog management dashboard at `your-app.com/dashboard/blog`.

## 🎨 Frontend Integration

The package includes frontend routes and views to display your blog.

  - **Blog Index Page:** `your-app.com/blog`
  - **Single Post Page:** `your-app.com/blog/{slug}`
  - **Category Page:** `your-app.com/blog/category/{slug}`

You can customize the frontend views by publishing them and editing the files in `resources/views/vendor/blog/`.

## 📦 What's Included?

  - **Migrations:** For `blogs`, `blog_categories`, `comments`, and `blog_likes` tables.
  - **Models:** `Blog`, `BlogCategory`, `Comment`, `BlogLike`.
  - **Controllers:** Backend controllers for managing posts and categories, and frontend controllers for displaying the blog.
  - **Views:** Blade templates for both the backend dashboard and the public-facing frontend, built with TailwindCSS.
  - **Routes:** Pre-configured web routes for backend and frontend functionality.

## 🤝 Contributing

Contributions are welcome\! If you find a bug or have a feature request, please open an issue on GitHub. If you'd like to contribute code, please fork the repository and submit a pull request.

## 📜 License

The `sndpbag/blog` package is open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.