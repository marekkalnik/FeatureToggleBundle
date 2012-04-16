EmkaFeatureToggleBundle
=======================

This bundle helps you easily configure your feature toggling in Symfony2
by adding some simple tags to twig and extending it's configuration.

It's under developement and even though it's functional, its behavior and configuration may (and will) change. 

Configuring your features
-------------------------

Add the following lines to your config.yml:

```
feature_toggle:
	features:
		my_feature:
			name: my_feature # the name you use in your template
			enabled: true    # false
```

Use feature toggling in your templates
-------------------------------------

Once you've configured your features, you can surround a block of code in Twig template with a `feature` tag.

```
{% feature 'my_feature' %}
    ... add you code
{% endfeature %}
```

Now setting `enabled: false` in config.yml will hide all part of code defined with same feature name.
After each configuration change don't forget to clear your cache to update your templates.
