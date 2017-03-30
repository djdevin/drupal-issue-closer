Drupal.org issue closer
===

While drupal.org does have a REST API, it is read-only.

So when you have 500+ issues (a lot of them being support issues with no reply) it gets really cluttered.

This is a bot that uses your own credentials to close tickets.

Drupal.org does not allow automated bots or user accounts that do not represent a single person.

This is in line with their ToS as it is using your account and credentials. I'm not responsible if you get banned though.

You probably shouldn't loop through all drupal.org issues and close them...

Installation
===
1. Checkout this repository
2. Run `composer install`

How to use
===
1. Take a look at features/drupal.feature.example
2. Copy that to features/mymodule.feature
3. Edit it so it looks like this:
```
Feature: Update old issues on drupal.org

Background:
When I am on "https://drupal.org/user"
And I fill in "Username or email" with "Dries"
And I fill in "Password" with "loveGor"
And I press "Log in"

Scenario Outline: I need to update old issues on drupal.org but they don't have any sort of bulk operations
Then I close all "mymodule" issues with version "<version>" and message:
"""
This issue is being closed because it was filed against a version that is no longer supported.

If the issue still persists in the latest version of my module, please open a new issue.
"""
Examples:
| version |
| 7.x-1.0-alpha1 |
| 7.x-1.0-alpha2 |
| 7.x-1.0-alpha3 |
```
4. Run `bin/behat features/mymodule.feature`

All issues with that version will be set to "Closed (outdated)" and a comment added.

You can put multiple scenarios in the same file, for multiple projects if you'd like.

ToDo
===
- Closing tickets by date (e.g. 1 year is now outdated)
- Closing/transitioning tickets by other critieria (e.g. old support tickets moving to "postponed")

Wishlist
===
drupal.org needs to add some VBOs
