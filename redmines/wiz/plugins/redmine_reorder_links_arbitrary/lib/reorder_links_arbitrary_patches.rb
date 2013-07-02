require 'rla_asset_helpers'

module ReorderLinksArbitrary
  module Patches
    module MoveToPosActsAsList
      def self.included(base) # :nodoc:
          base.send(:include, InstanceMethods)

          base.class_eval do
            unloadable # Send unloadable so it will not be unloaded in development
          end
      end

      module ClassMethods
      end

      module InstanceMethods
        def move_to_pos=(pos)
          return unless pos && respond_to?(:move_lower) && respond_to?(:move_higher)

          #logger.info("Position is #{pos}")

          if pos[0] == ?+ || pos[0] == ?-
            pos=pos.to_i
            if pos != 0
              dir=(pos>0 ? :move_lower : :move_higher)
              pos.abs.times do
                send(dir)
              end
            end
          else
            pos=pos.to_i
            if pos > 0
              if pos >= bottom_position_in_list.to_i
                move_to_bottom
              else
                if pos == 1
                  move_to_top
                else
                  insert_at_position(pos)
                end
              end
            end
          end
        end
      end
    end

    module ReorderLinksPatch
      def self.included(base) # :nodoc:

        base.send(:include, InstanceMethods)

        base.class_eval do
          unloadable # Send unloadable so it will not be unloaded in development
          alias_method_chain :reorder_links, :arbitrary_order
        end

      end

      module ClassMethods
      end

      module InstanceMethods
        def reorder_links_with_arbitrary_order(name, url, method = :post)
          submit_function =
              "var prompt_reply = prompt('#{escape_javascript(l(:prompt_sort_arbitrary))}'); " +
              "if(prompt_reply) { "+
              "  var f = document.createElement('form');" +
              "  f.style.display = 'none'; " +
              "  this.parentNode.appendChild(f);"+
              "  f.method = 'POST';"+
              "  f.action = this.href+'?#{name}%5Bmove_to_pos%5D='+encodeURIComponent(prompt_reply); "+

              "  var p = document.createElement('input');"+
              "  p.setAttribute('type', 'hidden'); "+
              "  p.setAttribute('name', 'prompt_reply');"+
              "  p.setAttribute('value', prompt_reply);"+
              "  f.appendChild(p);" +

              "  var m = document.createElement('input');"+
              "  m.setAttribute('type', 'hidden'); "+
              "  m.setAttribute('name', '_method');"+
              "  m.setAttribute('value', 'put');"+
              "  f.appendChild(m);" +

              "  var s = document.createElement('input');"+
              "  s.setAttribute('type', 'hidden'); " +
              "  s.setAttribute('name', '#{request_forgery_protection_token}');"+
              "  s.setAttribute('value', '#{escape_javascript(form_authenticity_token)}');"+
              "  f.appendChild(s);" +

              "  f.submit();"+
              "};"
          str_f=link_to_function(image_tag('arrow_out.png',
                                     :plugin => RLA_AssetHelpers::PLUGIN_NAME.to_s,
                                     :alt => l(:label_sort_arbitrary)),submit_function,
                                     :title => l(:label_sort_arbitrary),
                                     :href => url_for(url)
          )
          return reorder_links_without_arbitrary_order(name,url,method) + str_f.html_safe
        end
      end

    end
  end
end

unless ActiveRecord::Base.included_modules.include? ReorderLinksArbitrary::Patches::MoveToPosActsAsList
  ActiveRecord::Base.send(:include, ReorderLinksArbitrary::Patches::MoveToPosActsAsList)
end

unless ApplicationHelper.included_modules.include? ReorderLinksArbitrary::Patches::ReorderLinksPatch
  ApplicationHelper.send(:include, ReorderLinksArbitrary::Patches::ReorderLinksPatch)
end
