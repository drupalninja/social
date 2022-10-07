## Overview
This composer feature configures user profile pages to act like user timelines,
similar to Twitter and other social media applications.

Read full tutorial:
https://medium.com/@jrcallicott/create-a-twitter-style-application-in-drupal-8207e4aaef96

## Key Features
- User timeline with short posts
- User mentions
- Threads
- Likes
- Follow user posts
- Drush command for creating test users
- Easy to customize

## Quick start

1. **Install CKEditor libraries for mentions**

   Follow CKEditor README instructions to install required libraries
   https://git.drupalcode.org/project/ckeditor_mentions/-/blob/8.x-2.x/README.md

2. **Install the Social feature module**

   ```shell
   composer require 'drupalninja/social:1.x-dev'
   ```

3. **Enable Social feature**

   ```shell
   drush en -y social
   ```

4. **Place Timeline block**

   If you are not using the Olivero theme then you will need to
   place the Timeline block using either Block layout or Layout builder
   onto the user page.

5. **Create test users with comments**

   Included in this feature is a drush command that will generate test
   users and comments.
   ```shell
   drush sdu
   ```

## Customizing

- Views: liked_posts and posts_timeline can be customized
- "Posts" comment type can be customized
