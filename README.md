# Genny

Genny is a static site generator built primarily with Symfony components.

## Installation

Simply run "composer install" in the root of your project.

## Templates

Twig templates are used to generate site content. These are stored in the templates directory in the root of your project.

## Pages

Pages are YML files describing the URL, template and content for a page.

### Example

The following example would result in dist/index.html being created, using the template homepage.html.twig.

    # pages/homepage.yml
    page:
        _title: My Page Title # Optional
        _description: My Page Description # Optional
        _url: /index.html # Required
        _template: homepage.html.twig # Required
        my_example_list:
            - Example Item 1
            - Example Item 2
            
The associated template for the example above would look something like this

    <!DOCTYPE html>
    <html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>{{ _title }}</title>
        <meta name="description" content="{{ _description }}">
    </head>
    <body>
        <h1>Homepage</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        <ul>
            {% for item in my_example_list %}
                <li>{{ item }}</li>
            {% endfor %}
        </ul>
    </body>
    </html>
    
## Commands

Genny provides a command line interface for generating pages.

### generate-page

Generate all pages

    app/genny generate-page
    
Generate a specific page

    app/genny generate-page homepage
    
### watch

Watch all templates and pages for changes, generating new files in dist as the changes happen.

    app/genny watch