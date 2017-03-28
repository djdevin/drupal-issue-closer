Feature: Update old issues on drupal

Background:
When I am on "https://drupal.org/user"
And I fill in "Username or email" with "djdevin"
And I fill in "Password" with ""
And I press "Log in"

Scenario Outline: I need to update old issues on drupal
Then I close all the active "<version>" issues
Examples:
| version |
| 7.x-4.0-alpha1 |
| 7.x-4.0-alpha2 |
| 7.x-4.0-alpha3 |
| 7.x-4.0-alpha4 |
| 7.x-4.0-alpha5 |
| 7.x-4.0-alpha6 |
| 7.x-4.0-alpha7 |
| 7.x-4.0-alpha8 |
| 7.x-4.0-alpha9 |
| 7.x-4.0-alpha10 |
| 7.x-4.0-alpha11 |
| 7.x-4.0-alpha12 |
