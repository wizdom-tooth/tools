require 'redmine'
require 'dispatcher' unless Rails::VERSION::MAJOR >= 3
require 'rla_asset_helpers'

unless Redmine::Plugin.registered_plugins.keys.include?(RLA_AssetHelpers::PLUGIN_NAME)
	Redmine::Plugin.register RLA_AssetHelpers::PLUGIN_NAME do
	  name 'Reorder links arbitrary'
	  author 'Vitaly Klimov'
	  author_url 'mailto:vitaly.klimov@snowbirdgames.com'
	  description 'Plugin allows to move items in ordered lists (trackers, enumerations, roles, forums, etc) to any position'
	  version '0.0.7'
	end
end

if Rails::VERSION::MAJOR >= 3
  ActionDispatch::Callbacks.to_prepare do
    require 'reorder_links_arbitrary_patches'
  end if Rails.env.production?
else
  Dispatcher.to_prepare RLA_AssetHelpers::PLUGIN_NAME do
    require_dependency 'reorder_links_arbitrary_patches'
  end if ENV['RAILS_ENV'] == 'production'
end
