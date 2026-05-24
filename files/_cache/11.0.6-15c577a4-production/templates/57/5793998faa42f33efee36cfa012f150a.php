<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* pages/setup/webhook/webhook_headers.html.twig */
class __TwigTemplate_dc8d59d0706cbe089629f77b3ef4e1e4 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'form_fields' => [$this, 'block_form_fields'],
            'more_fields' => [$this, 'block_more_fields'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 33
        return "generic_show_form.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 34
        $macros["fields"] = $this->macros["fields"] = $this->load("components/form/fields_macros.html.twig", 34)->unwrap();
        // line 35
        $context["params"] = (((array_key_exists("params", $context) &&  !(null === $context["params"]))) ? ($context["params"]) : ([]));
        // line 36
        $context["rand_field"] = ((array_key_exists("rand", $context)) ? (Twig\Extension\CoreExtension::default(($context["rand"] ?? null), Twig\Extension\CoreExtension::random($this->env->getCharset()))) : (Twig\Extension\CoreExtension::random($this->env->getCharset())));
        // line 33
        $this->parent = $this->load("generic_show_form.html.twig", 33);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 38
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_form_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 39
        yield "   ";
        yield from $this->unwrap()->yieldBlock('more_fields', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_more_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 40
        yield "      <template id=\"custom-header-fields-template\">
         ";
        // line 41
        $context["header_field_pair"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 42
            yield "            ";
            yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 42, $this->getSourceContext())->macro_textField(...["header_name[]", "", "", ["no_label" => true, "field_class" => "col-4"]]);
            // line 45
            yield "
            ";
            // line 46
            $context["remove_btn"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                // line 47
                yield "               <button class=\"btn btn-danger btn-icon\" name=\"remove_header\" type=\"button\" title=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Remove"), "html", null, true);
                yield "\">
                  <i class=\"ti ti-trash\"></i>
               </button>
            ";
                yield from [];
            })())) ? '' : new Markup($tmp, $this->env->getCharset());
            // line 51
            yield "            ";
            $context["header_value_autocomplete"] = new Markup("                <div class=\"header_value form-control overflow-hidden\" style=\"height: 36px\"></div>
            ", $this->env->getCharset());
            // line 54
            yield "            ";
            yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 54, $this->getSourceContext())->macro_htmlField(...["header_value[]", ($context["header_value_autocomplete"] ?? null), "", ["no_label" => true, "field_class" => "ms-2 h-100 d-flex col-5 justify-content-center", "wrapper_class" => "d-flex flex-grow-1", "add_field_html" =>             // line 58
($context["remove_btn"] ?? null)]]);
            // line 59
            yield "
         ";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 61
        yield "         ";
        yield $macros["fields"]->getTemplateForMacro("macro_field", $context, 61, $this->getSourceContext())->macro_field(...["custom_header[]", ($context["header_field_pair"] ?? null), "", ["no_label" => true, "field_class" => "col-12 d-flex custom-header-field-pair"]]);
        // line 64
        yield "
      </template>

      <div class=\"custom-header-fields\">
         <button class=\"btn btn-secondary\" name=\"add_header\" type=\"button\">
            <i class=\"ti ti-plus\"></i>
            ";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Add a custom header"), "html", null, true);
        yield "
         </button>
      </div>

      <script>
          const add_custom_header = (name, value, readonly) => {
              const custom_header_fields_container = \$('div.custom-header-fields');
              const template = \$(\$('#custom-header-fields-template').html());
              const header_name_field = template.find('input[name=\"header_name[]\"]');
              const header_value_id = `header_value\${Math.round(Math.random() * 1000000)}`;
              \$(``).insertAfter(template.find('input[name=\"header_value[]\"]'));
              template.find('div.header_value').prop('id', header_value_id);
              header_name_field.val(name);
              const editor_options = window.GLPI.Monaco.getSingleLineEditorOptions();
              if (readonly) {
                  header_name_field.prop('readonly', true);
                  // Delete the remove button
                  template.find('button[name=\"remove_header\"]').remove();
                  editor_options.readOnly = true;
              }
              // insert the template before the add button
              \$(template).insertBefore(custom_header_fields_container.find('button[name=\"add_header\"]'));
              window.GLPI.Monaco.createEditor(header_value_id, 'twig', value, ";
        // line 92
        yield json_encode(($context["response_schema"] ?? null));
        yield ", editor_options);
          };
          \$(() => {
              const known_custom = ";
        // line 95
        yield json_encode(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, true, false, 95), "custom_headers", [], "array", true, true, false, 95)) ? (Twig\Extension\CoreExtension::default((($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 95)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["custom_headers"] ?? null) : null), [])) : ([])), Twig\Extension\CoreExtension::constant("JSON_FORCE_OBJECT"));
        yield ";
              add_custom_header('X-GLPI-signature', __('Filled automatically'), true);
              add_custom_header('X-GLPI-timestamp', __('Filled automatically'), true);
              ";
        // line 98
        if ((($tmp = (($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 98)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["use_oauth"] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 99
            yield "                 add_custom_header('Authorization', __('Filled automatically'), true);
              ";
        }
        // line 101
        yield "              for (const [name, value] of Object.entries(known_custom)) {
                  add_custom_header(name, value);
              }
              \$('div.custom-header-fields').on('click', 'button[name=\"add_header\"]', () => {
                  add_custom_header('', '');
              }).on('click', 'button[name=\"remove_header\"]', (e) => {
                  const header_pair = \$(e.target).closest('.custom-header-field-pair');
                  header_pair.find('.header_value').each((i, editor_dom) => {
                      const editor = window.monaco.editor.getEditors().find((ed) => ed._domElement === editor_dom);
                      if (editor) {
                          editor.dispose();
                      }
                  });
                  header_pair.remove();
              });

              // Add formdata handler to inject the custom header values from the monaco editors
              \$('div.custom-header-fields').closest('form').on('formdata', (e) => {
                  const editors = window.monaco.editor.getEditors().filter((editor) => {
                      return editor._domElement.classList.contains('header_value');
                  });
                  // remove all header_name[] and header_value[] from the formdata
                  e.originalEvent.formData.delete('header_name[]');
                  e.originalEvent.formData.delete('header_value[]');

                  \$(editors).each((i, editor) => {
                      const header_name = \$(editor._domElement).closest('.custom-header-field-pair').find('input[name=\"header_name[]\"]').val();
                      const header_value = editor.getValue();
                      e.originalEvent.formData.append('header_name[]', header_name);
                      e.originalEvent.formData.append('header_value[]', header_value);
                  });
              });
          });
      </script>
   ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "pages/setup/webhook/webhook_headers.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  167 => 101,  163 => 99,  161 => 98,  155 => 95,  149 => 92,  124 => 70,  116 => 64,  113 => 61,  108 => 59,  106 => 58,  104 => 54,  100 => 51,  91 => 47,  89 => 46,  86 => 45,  83 => 42,  81 => 41,  78 => 40,  66 => 39,  59 => 38,  54 => 33,  52 => 36,  50 => 35,  48 => 34,  41 => 33,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/webhook/webhook_headers.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\webhook\\webhook_headers.html.twig");
    }
}
