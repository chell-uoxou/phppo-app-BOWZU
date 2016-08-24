# phppo-plugin-InstantCommandLoader
Load php files to add PHPPO command.

## How to install
1. Put on __"root/plugins"__ directory phar file.
2. Boot PHP Prompt OS and install plugin.
3. Check the existence of __"root/bin/InstantCommandLoader"__ directory. _(When run `plugins` displayed on it?)_
4. Put raw PHP files on __"root/bin/InstantCommandLoader/includes"__.
5. Write extension command and path _(like `command = path`)_ on __"root/bin/InstantCommandLoader/extensions.ini"__
6. Write command description _(like `command = description`)_ on __"root/bin/InstantCommandLoader/extension_descriptions.ini"__ _(optional)_
7. Run `icl reload` command.
8. Enjoy!
