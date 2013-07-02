module RedmineTextilizableCustomFields
  module QueriesHelperPatch
    unloadable

    def self.included(base)
      base.send(:include, InstanceMethods)
      base.class_eval do
        alias_method_chain :column_value, :textilizable
      end
    end

    module InstanceMethods
      def column_value_with_textilizable(column, issue, value)
        if value.is_a?(String) && column.is_a?(QueryCustomFieldColumn) && column.custom_field.textilizable?
          textilizable(value)
        else
          column_value_without_textilizable(column, issue, value)
        end
      end
    end
  end
end
