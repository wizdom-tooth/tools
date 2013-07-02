class AddTextilizableToCustomFields < ActiveRecord::Migration
  def self.up
    add_column :custom_fields, :textilizable, :boolean, :default => false, :null => false
  end
  def self.down
    remove_column :custom_fields, :textilizable
  end
end
