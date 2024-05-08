# What is this?
PHP code that converts Markdown to HTML using Parsedown and Bootstrap libraries.
# Usage
Create two folders called “md” and “html”, put your Markdown files in the md folder. it scans all files and folders for .md files. Then run the PHP code and everything is done, your “html” folder will contain your HTML files. By default it uses a dark theme, if you don't want this change data-bs-theme=“dark” to light in the PHP code. A single style is added that removes the lines under the links, if you don't want this, delete <style>. Put converted content into a container by default in the HTML code, delete <div class=“container”> if you don't want this. To set the title, edit the <title> part of the PHP code, it doesn't give options but it's useful.
# Issues
...