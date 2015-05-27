# Magento WP Rest Module #

Magento and WordPress were always the mighty combination as Magento is lacking quality CMS control. Over the years, there were many extensions developed to run Magento inside WordPress and vice versa. However, they were all lacking ability to naturally or easily connect Magento and WordPress and mostly — they were not SEO friendly.

Recently, WordPress made an announcement that they will be adopting a [WP Rest API](https://gist.github.com/rmccue/722769379f4fc4148b1f) into core.

Magento WP Rest module solves problems caused by Magento's feature lacking CMS by integrating WordPress blog through WP Rest Api. With almost no configuration, your blog can now become natural part of your store. This will allow user to write content using WordPress and it's rich options, while posts, pages and categories will be showing in Magento.

Here is the overview of features provided by WP Rest module:
* To access single post, you can just use it's URL identifier: http://example.com/post-slug
* Same goes for page - http://example.com/page-url-slug
* To access list of posts from any category - http://example.com/category-slug
* SEO and user friendly urls
* Easy setup, with almost no configuration
* Configurable blog homepage url (not depending on your blog installation path)
* Cross domain support

Requirements:
* On WordPress side, you will need: [WP-API](https://github.com/WP-API/WP-API) (v1.2.2)
* On Magento side, you will need [Magento WP Rest Module](https://github.com/stuntcoders/stunt_mage_wprest)

## Configuration ##

Configuration for Magento WP Rest module can be found in *Magento Admin Panel -> System -> Configuration -> WordPress Configuration*:

* **API endpoint** - Defines the url where WordPress API is located. Url must be absolute and can be both same and different than domain on which Magento store is. Example: http://example.com/side/wp-json
* **Homepage path** - Defines the path which will represent the blog homepage. On this page, most recent post will be displayed. Default value is: *site* and but you can change it to most suitable and SEO friendly setting depending on your website language. For example, if you would set it to "blog", your URL would be: http://example.com/blog

Copyright StuntCoders — [Start Your Online Store Now](http://stuntcoders.com/start-your-online-store)
