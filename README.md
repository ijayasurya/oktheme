# OK Theme - WordPress Blog Theme with Tailwind CSS

A modern, clean WordPress blog theme built with Tailwind CSS v4. Features responsive design, customizable options, and conditional sidebar support.

## Features

- ✅ **Tailwind CSS v4** - Modern utility-first CSS framework
- ✅ **Responsive Design** - Mobile-first, fully responsive layout
- ✅ **Navigation System** - Custom navigation walker with mobile menu support
- ✅ **Conditional Sidebar** - Sidebar appears on home, archive, post, tag, and category pages (not on pages)
- ✅ **Theme Customization** - Extensive WordPress Customizer options
- ✅ **Clean Code** - Well-organized, reusable, and maintainable code structure
- ✅ **Developer Friendly** - Hot reload support for development

## Installation

1. **Install Dependencies**
   ```bash
   pnpm install
   ```

2. **Build CSS for Production**
   ```bash
   pnpm run build
   ```

3. **Development Mode (with watch)**
   ```bash
   pnpm run dev
   ```

4. **Activate Theme**
   - Go to WordPress Admin → Appearance → Themes
   - Activate "OK Theme"

## Development

### File Structure

```
oktheme/
├── inc/                          # Theme functionality
│   ├── class-oktheme-walker-nav-menu.php  # Custom navigation walker
│   ├── customizer.php            # Theme customizer options
│   └── template-tags.php         # Custom template functions
├── js/                           # JavaScript files
│   └── navigation.js            # Mobile menu functionality
├── src/                          # Source files
│   └── input.css                # Tailwind CSS input file
├── style.css                    # Compiled CSS (generated)
├── functions.php                 # Main theme functions
├── header.php                   # Header template
├── footer.php                   # Footer template
├── sidebar.php                  # Sidebar template
├── index.php                    # Main blog template
├── single.php                   # Single post template
├── page.php                     # Page template (no sidebar)
├── archive.php                  # Archive template
├── search.php                   # Search results template
├── 404.php                      # 404 error template
├── comments.php                 # Comments template
└── searchform.php               # Search form template
```

### Customization

#### Colors

Custom colors are defined in `src/input.css` using the `@theme` directive:

```css
@theme {
	--color-primary: #3b82f6;
	--color-primary-dark: #2563eb;
	--color-primary-light: #60a5fa;
	--color-secondary: #64748b;
	--color-secondary-dark: #475569;
	--color-secondary-light: #94a3b8;
}
```

#### Theme Customizer Options

The theme includes several customization options accessible via **Appearance → Customize**:

- **Color Scheme**: Primary and secondary colors
- **Typography**: Body font size
- **Layout**: Container max width
- **Footer**: Footer text customization
- **Social Media**: Links to social media profiles

#### Sidebar Display Logic

The sidebar is conditionally displayed using the `oktheme_should_display_sidebar()` function:

- ✅ **Shows on**: Home, Archive, Single Post, Tag, Category pages
- ❌ **Hidden on**: Pages

This logic is implemented in `functions.php` and used in all template files.

## Navigation

### Registering Menus

The theme supports two menu locations:
- **Primary Menu**: Main navigation (header)
- **Footer Menu**: Footer navigation

To set up menus:
1. Go to **Appearance → Menus**
2. Create a new menu or select an existing one
3. Assign it to "Primary Menu" or "Footer Menu" location

### Custom Navigation Walker

The theme includes a custom navigation walker (`OKTheme_Walker_Nav_Menu`) that adds Tailwind CSS classes for better styling and hover effects.

## Widget Areas

The theme includes the following widget areas:

1. **Sidebar** (`sidebar-1`) - Main sidebar for blog pages
2. **Footer Widget Area 1** (`footer-1`)
3. **Footer Widget Area 2** (`footer-2`)
4. **Footer Widget Area 3** (`footer-3`)

## Template Tags

Custom template functions available in `inc/template-tags.php`:

- `oktheme_posted_on()` - Display post date and author
- `oktheme_post_categories()` - Display post categories
- `oktheme_post_tags()` - Display post tags
- `oktheme_pagination()` - Custom pagination
- `oktheme_excerpt()` - Custom excerpt with length control

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11+ (with polyfills if needed)

## Requirements

- WordPress 5.0+
- PHP 7.4+
- Node.js 16+ (for development)
- pnpm (or npm/yarn)

## License

GPL-2.0-or-later

## Credits

Built with [Tailwind CSS](https://tailwindcss.com/) and [WordPress](https://wordpress.org/).

