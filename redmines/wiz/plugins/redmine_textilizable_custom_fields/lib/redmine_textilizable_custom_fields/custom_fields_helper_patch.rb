module RedmineTextilizableCustomFields
  module CustomFieldsHelperPatch
    unloadable

    def self.included(base)
      base.send(:include, InstanceMethods)
      base.class_eval do
        alias_method_chain :custom_field_tag, :textilizable
        alias_method_chain :custom_field_tag_for_bulk_edit, :textilizable
        alias_method_chain :show_value, :textilizable
      end
    end

    module InstanceMethods
      def custom_field_tag_with_textilizable(name, custom_value)
        str = custom_field_tag_without_textilizable(name, custom_value)
        custom_field = custom_value.custom_field
        field_format = Redmine::CustomFieldFormat.find_by_name(custom_field.field_format)
        if custom_field.textilizable? && field_format.try(:edit_as) == 'text'
          str += wikitoolbar_for("#{name}_custom_field_values_#{custom_field.id}")
        end
        str
      end
      def custom_field_tag_for_bulk_edit_with_textilizable(name, custom_field, projects=nil)
        str = custom_field_tag_for_bulk_edit_without_textilizable(name, custom_field, projects)
        field_format = Redmine::CustomFieldFormat.find_by_name(custom_field.field_format)
        if custom_field.textilizable? && field_format.try(:edit_as) == 'text'
          str += wikitoolbar_for("#{name}_custom_field_values_#{custom_field.id}")
        end
        str
      end
      def show_value_with_textilizable(custom_value)
        str = show_value_without_textilizable(custom_value)
        return str if respond_to?(:template) && template.format == "text"
        return str if respond_to?(:formats) && formats.include?(:text)
        return str unless custom_value && custom_value.custom_field.textilizable?
        textilizable(str)
      end
    end

  end
end