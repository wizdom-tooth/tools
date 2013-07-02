require 'redmine'
require 'redmine_textilizable_custom_fields/hooks'

to_prepare = Proc.new do
  unless CustomFieldsHelper.included_modules.include?(RedmineTextilizableCustomFields::CustomFieldsHelperPatch)
    CustomFieldsHelper.send(:include, RedmineTextilizableCustomFields::CustomFieldsHelperPatch)
  end
  unless QueriesHelper.included_modules.include?(RedmineTextilizableCustomFields::QueriesHelperPatch)
    QueriesHelper.send(:include, RedmineTextilizableCustomFields::QueriesHelperPatch)
  end
end

if Redmine::VERSION::MAJOR >= 2
  Rails.configuration.to_prepare(&to_prepare)
else
  require 'dispatcher'
  Dispatcher.to_prepare(:redmine_textilizable_custom_fields, &to_prepare)
end

Redmine::Plugin.register :redmine_textilizable_custom_fields do
  name 'Redmine Textilizable Custom Fields plug-in'
  author 'Anton Argirov'
  author_url 'http://redmine.academ.org'
  description 'Adds textilizable support to text and long text custom fields'
  url "http://redmine.academ.org"
  version '0.0.1'
end

