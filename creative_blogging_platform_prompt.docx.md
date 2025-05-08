# Creative Blogging Platform Prompt

Build a complete blogging platform using PHP with CodeIgniter 4 framework. The application should include both a frontend for users and an admin panel for blog management. Use Tailwind CSS for the frontend design to make it creative, modern, and responsive.

# **Project Structure**

Use MVC architecture as per CodeIgniter 4 standards. Follow clean routing and file organization. Place views in app/Views/, controllers in app/Controllers/, and models in app/Models.

# **Admin Panel Features (/admin)**

Use a clean dashboard layout (can be Bootstrap or Tailwind UI).

Pages:

\- Admin login/logout

\- Dashboard with blog stats (post count, views, etc.)

\- Manage Blog Posts (list/add/edit/delete)

\- Manage Categories

\- Manage Tags (optional)

\- Upload blog thumbnail (image uploader)

\- Rich text editor (CKEditor or TinyMCE)

\- Set blog status (draft/published)

\- Generate and edit SEO-friendly slugs

# **Database tables:**

\- users: id, email, password (hashed), name, role(admin/editor/user)

\- posts: id, user\_id, title, slug, content, thumbnail, category\_id, status, view, created\_at, published\_at, updated\_at

\- categories: id, name, slug

\- tags: id, name, slug

\- post\_tags: post\_id, tag\_id, created\_at

\- post\_photos: post\_id, file\_path

# **Frontend Features (/)**

Use Tailwind CSS to design a beautiful, modern UI.

Pages:

\- Home page with:

  \- Featured posts section

  \- Latest blogs (grid)

  \- Category filter buttons

  \- Search bar

\- Blog detail page (/blog/{slug}):

  \- Large thumbnail

  \- Readable content with formatting

  \- Post metadata (author, date, tags)

  \- Related posts section

\- Category page (/category/{slug}) with filtered posts

\- Search results page (/search?q=)

\- 404 page

\- Optional:

  \- About page

  \- Contact page

  \- Newsletter subscription form

Meta & SEO:

\- Use blog slug in the URL

\- Include dynamic meta title, description, and OpenGraph tags

\- Schema.org blog post markup in blog detail pages

# **Other Requirements**

Blog content should be editable via WYSIWYG editor.

Store uploaded thumbnails in /public/files/{user\_id}/{post\_id}/

Uploaded thumbnails will be converted to max 2048\*Ratio height size.

Apply Tailwind typography plugin if possible.

Add pagination to all post listings.

Use Laravel-style flash messages for admin actions.

Apply form validation on all admin forms.

When the user clicks on add new post first, Post will be generated in database and then post will be auto save after each 15 seconds.

Some shortcuts will be handled as follows:

1. Ctrl+n opens a new tab and creates a new post.   
2. Ctrl+s will save the post immediately.  
3. Ctrl+p will publish the post.

# **Performance Optimization**

To ensure high-speed loading and efficient scaling:

* **Post Caching Mechanism**  
  Cache each blog post’s HTML output after it’s rendered for the first time. Use file-based or Redis caching to store the post content.

  * Use cache()-\>save() and cache()-\>get() methods in CodeIgniter 4\.

  * Bypass the cache only when:

    * The post is updated or deleted.

    * Views count is being recorded.

    * The sitemap is being generated.

  * Ensure a cache invalidation strategy when an admin edits or deletes content.

# **AMP (Accelerated Mobile Pages)**

Create AMP-compatible versions of all blog posts and category pages to boost SEO and load performance on mobile:

* Use AMP-compliant HTML and components (\<amp-img\>, inline CSS, etc.).

* Route examples:

  * /amp/blog/{slug}

  * /amp/category/{slug}

* In each normal page, add:

  html

  \<link rel="amphtml" href="/amp/blog/{slug}"\>

* Exclude heavy scripts and use AMP validator to verify pages.

* Add canonical references from AMP to standard pages.

**Frontend Design Reference**

The frontend of the blogging platform should be **creative, clean, and modern**. Use [HubSpot’s blog layout](https://blog.hubspot.com/) as an **inspiration for layout, spacing, typography, and content hierarchy**. Key characteristics:

* Clean grid layout for featured and latest posts

* Large readable typography

* Clear category labels and filters

* Minimalist header and footer

* Good use of white space and responsive design

Use Tailwind CSS for all styling, including responsive layouts, cards, buttons, and typography enhancements (consider using the Tailwind Typography plugin).

Website and admin panel should be creative, colourful and use the animations for better visualization.

# **Deployment**

Ensure it can be deployed on GoDaddy Shared Hosting, so:

\- Use CodeIgniter’s .htaccess for clean URLs

\- Configure base URL properly

\- Upload public folder contents to public\_html and set index.php path accordingly

# **Output**

A fully functional blogging platform with:

\- Admin panel (login \+ blog management)

\- Modern frontend (Tailwind CSS)

\- Blog listing, filtering, reading

\- SEO-friendly structure

\- Easy-to-maintain codebase using CodeIgniter 4