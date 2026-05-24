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

/* pages/setup/webhook/payload_editor.html.twig */
class __TwigTemplate_5f75685124a2313f7b2f372d7fc91577 extends Template
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

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 32
        yield "
";
        // line 33
        $macros["fields"] = $this->macros["fields"] = $this->load("components/form/fields_macros.html.twig", 33)->unwrap();
        // line 34
        yield "
<div>
   ";
        // line 36
        yield $macros["fields"]->getTemplateForMacro("macro_sliderField", $context, 36, $this->getSourceContext())->macro_sliderField(...["use_default_payload", (($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 36)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["use_default_payload"] ?? null) : null), __("Use default payload"), ["align_label_right" => false, "label_class" => "col-xxl-4"]]);
        // line 39
        yield "
</div>
<div id=\"webhook-payload-editor-container\" data-webhook-id=\"";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 41)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["id"] ?? null) : null), "html", null, true);
        yield "\">
   <div id=\"webhook-payload-editor-toolbar\" class=\"mx-1\" style=\"font-size: 1.25em\">
      <button name=\"editor_save\" class=\"btn btn-icon btn-ghost-secondary\">
         <i class=\"ti ti-device-floppy\" title=\"";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(_x("button", "Save"), "html", null, true);
        yield "\" aria-label=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(_x("button", "Save"), "html", null, true);
        yield "\"></i>
      </button>
      <button name=\"editor_find\" class=\"btn btn-icon btn-ghost-secondary\">
         <i class=\"ti ti-search\" title=\"";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Search"), "html", null, true);
        yield "\" aria-label=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Search"), "html", null, true);
        yield "\"></i>
      </button>
   </div>
   <div id=\"payload\" class=\"webhook-payload-editor\" style=\"height: 600px\"></div>
   <div id=\"default_payload\" class=\"d-none\">
      ";
        // line 52
        yield $macros["fields"]->getTemplateForMacro("macro_textareaField", $context, 52, $this->getSourceContext())->macro_textareaField(...["default_payload", ($context["default_payload"] ?? null), "", ["readonly" => "readonly", "input_class" => "col-12", "field_class" => "col-12", "rows" => 30]]);
        // line 57
        yield "
   </div>
</div>
<script type=\"module\">
    ";
        // line 61
        $context["payload"] = ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, true, false, 61), "payload", [], "array", true, true, false, 61)) ? (Twig\Extension\CoreExtension::default((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 61)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2["payload"] ?? null) : null), ($context["default_payload"] ?? null))) : (($context["default_payload"] ?? null)));
        // line 62
        yield "    window.GLPI.Monaco.createEditor('payload', 'twig', ";
        yield json_encode(($context["payload"] ?? null));
        yield ", ";
        yield json_encode(($context["response_schema"] ?? null));
        yield ").then((monaco) => {
        \$(\"#webhook-payload-editor-container button[name='editor_find']\").on('click', function() {
            monaco.editor.getAction('actions.find').run();
        });
        \$(\"#webhook-payload-editor-container button[name='editor_save']\").on('click', function() {
            let payload_template = '';
            let reload_page = false;
            if (!\$('#payload').hasClass('d-none')) {
                payload_template = monaco.editor.getValue();
            }
            \$.ajax({
                url: CFG_GLPI['root_doc'] + '/ajax/webhook.php',
                type: 'POST',
                data: {
                    action: 'update_payload_template',
                    webhook_id: \$(\"#webhook-payload-editor-container\").data('webhook-id'),
                    payload_template: payload_template,
                    use_default_payload: \$('input[name=\"use_default_payload\"]').is(':checked'),
                }
            }).done(function() {
                if (reload_page) {
                    window.location.reload();
                } else {
                    glpi_toast_info(__('Saved'));
                }
            });
        });
        \$('input[name=\"use_default_payload\"]').on('change', () => {
            const is_default_payload = \$('input[name=\"use_default_payload\"]').is(':checked');
            if (is_default_payload) {
                \$('#webhook-payload-editor-toolbar button').addClass('d-none');
                \$('#payload').addClass('d-none');
                \$('#default_payload').removeClass('d-none');
            } else {
                \$('#webhook-payload-editor-toolbar button').removeClass('d-none');
                \$('#payload').removeClass('d-none');
                \$('#default_payload').addClass('d-none');
                // Force Monaco layout
                monaco.editor.layout();
            }
            // Force save button to be visible
            \$('#webhook-payload-editor-toolbar button:first').removeClass('d-none');
        });
        \$('input[name=\"use_default_payload\"]').trigger('change');
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
        return "pages/setup/webhook/payload_editor.html.twig";
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
        return array (  91 => 62,  89 => 61,  83 => 57,  81 => 52,  71 => 47,  63 => 44,  57 => 41,  53 => 39,  51 => 36,  47 => 34,  45 => 33,  42 => 32,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/webhook/payload_editor.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\webhook\\payload_editor.html.twig");
    }
}
