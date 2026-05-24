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

/* pages/setup/webhook/webhooktest.html.twig */
class __TwigTemplate_cb9d7441eeff356dbaef83517144a878 extends Template
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
        yield "       <div class=\"tab-content p-2 flex-grow-1 card \" style=\"min-height: 150px\">
           <div class=\"card-body d-flex flex-wrap\">
               <div class=\"col-12 col-xxl-12 flex-column\">
                   <div class=\"d-flex flex-row flex-wrap flex-xl-nowrap\">
                       <div class=\"row flex-row align-items-start flex-grow-1\">
                           <div class=\"row flex-row\">

                               ";
        // line 47
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownArrayField", $context, 47, $this->getSourceContext())->macro_dropdownArrayField(...["itemtype", (($_v0 = CoreExtension::getAttribute($this->env, $this->source,         // line 49
($context["item"] ?? null), "fields", [], "any", false, false, false, 49)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["itemtype"] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source,         // line 50
($context["item"] ?? null), "getItemtypesDropdownValues", [], "method", false, false, false, 50), __("Itemtype"), Twig\Extension\CoreExtension::merge(        // line 52
($context["field_options"] ?? null), ["display_emptychoice" => true, "rand" =>         // line 54
($context["rand_field"] ?? null), "disabled" => true])]);
        // line 57
        yield "

                               ";
        // line 59
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownArrayField", $context, 59, $this->getSourceContext())->macro_dropdownArrayField(...["event", (($_v1 = CoreExtension::getAttribute($this->env, $this->source,         // line 61
($context["item"] ?? null), "fields", [], "any", false, false, false, 61)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["event"] ?? null) : null), CoreExtension::getAttribute($this->env, $this->source,         // line 62
($context["item"] ?? null), "getGlpiEventsList", [(($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 62)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2["itemtype"] ?? null) : null)], "method", false, false, false, 62), _n("Event", "Events", 1), Twig\Extension\CoreExtension::merge(        // line 64
($context["field_options"] ?? null), ["display_emptychoice" => true, "container_id" => "show_event_field", "disabled" => true])]);
        // line 69
        yield "

                               ";
        // line 71
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownArrayField", $context, 71, $this->getSourceContext())->macro_dropdownArrayField(...["items_id", "", [], _n("Item", "Items", 1), Twig\Extension\CoreExtension::merge(        // line 76
($context["field_options"] ?? null), ["display_emptychoice" => true, "container_id" => "show_items_field"])]);
        // line 80
        yield "

                               ";
        // line 82
        $this->extensions['Glpi\Application\View\Extension\PhpExtension']->call("Ajax::updateItemOnSelectEvent", [("dropdown_itemtype" .         // line 83
($context["rand_field"] ?? null)), "show_items_field", ($this->extensions['Glpi\Application\View\Extension\ConfigExtension']->config("root_doc") . "/ajax/webhook.php"), ["itemtype" => "__VALUE__", "action" => "get_items_from_itemtype"]]);
        // line 91
        yield "
                               ";
        // line 92
        yield $macros["fields"]->getTemplateForMacro("macro_nullField", $context, 92, $this->getSourceContext())->macro_nullField(...[]);
        yield "

                               ";
        // line 94
        $context["cra_btn"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 95
            yield "                                   <button class=\"btn btn-primary me-2\" type=\"button\" name=\"get_webhook_response\" value=\"1\">
                                       <i class=\"ti ti-bolt\"></i>
                                       <span>";
            // line 97
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(_x("button", "See result"), "html", null, true);
            yield "</span>
                                   </button>
                               ";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 100
        yield "
                               ";
        // line 101
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 101, $this->getSourceContext())->macro_htmlField(...["",         // line 103
($context["cra_btn"] ?? null), "",         // line 105
($context["field_options"] ?? null)]);
        // line 106
        yield "

                               ";
        // line 108
        $context["raw_output_field"] = new Markup("                                   <div class=\"row flex-row justify-content-center\">
                                       <div class=\"tab-content p-2 flex-grow-1 card\">
                                           <pre class=\"bg-white text-dark\" name=\"webhook_result\" style=\"white-space: pre-wrap;\"></pre>
                                       </div>
                                   </div>
                               ", $this->env->getCharset());
        // line 115
        yield "                               ";
        yield $macros["fields"]->getTemplateForMacro("macro_nullField", $context, 115, $this->getSourceContext())->macro_nullField(...[]);
        yield "
                               ";
        // line 116
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 116, $this->getSourceContext())->macro_htmlField(...["",         // line 118
($context["raw_output_field"] ?? null), __("Complete output from the API"), ["is_horizontal" => false]]);
        // line 122
        yield "

                               ";
        // line 124
        $context["payload_output_field"] = new Markup("                                   <div class=\"row flex-row justify-content-center\">
                                       <div class=\"tab-content p-2 flex-grow-1 card\">
                                           <pre class=\"bg-white text-dark\" name=\"webhook_payload_result\" style=\"white-space: pre-wrap;\"></pre>
                                       </div>
                                   </div>
                               ", $this->env->getCharset());
        // line 131
        yield "                               ";
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 131, $this->getSourceContext())->macro_htmlField(...["",         // line 133
($context["payload_output_field"] ?? null), __("Payload output"), ["is_horizontal" => false]]);
        // line 137
        yield "

                               <script>
                                   \$(() => {
                                       \$('select[name=\"itemtype\"]').trigger('change');
                                   });
                                   \$('button[name=\"get_webhook_response\"]').click(() => {
                                       const itemtype = \$('select[name=\"itemtype\"]').val();
                                       const items_id = \$('select[name=\"items_id\"]').val();
                                       const event = \$('select[name=\"event\"]').val();

                                       \$.ajax({
                                           type: 'POST',
                                           url: '";
        // line 150
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Glpi\Application\View\Extension\RoutingExtension']->path("/ajax/webhook.php"), "html", null, true);
        yield "',
                                           data: {
                                               action: 'get_webhook_body',
                                               itemtype : itemtype,
                                               items_id: items_id,
                                               event: event,
                                               raw_output: true
                                           },
                                           success: function(response) {
                                               \$('pre[name=\"webhook_result\"]').text(response);
                                           },
                                       });

                                       \$.ajax({
                                           type: 'POST',
                                           url: '";
        // line 165
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Glpi\Application\View\Extension\RoutingExtension']->path("/ajax/webhook.php"), "html", null, true);
        yield "',
                                           data: {
                                               action: 'get_webhook_body',
                                               itemtype: itemtype,
                                               items_id: items_id,
                                               event: event,
                                               webhook_id: ";
        // line 171
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 171)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3["id"] ?? null) : null), "html", null, true);
        yield ",
                                           },
                                           success: function(response) {
                                               \$('pre[name=\"webhook_payload_result\"]').text(response);
                                           },
                                       });
                                   });
                               </script>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "pages/setup/webhook/webhooktest.html.twig";
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
        return array (  220 => 171,  211 => 165,  193 => 150,  178 => 137,  176 => 133,  174 => 131,  167 => 124,  163 => 122,  161 => 118,  160 => 116,  155 => 115,  148 => 108,  144 => 106,  142 => 105,  141 => 103,  140 => 101,  137 => 100,  130 => 97,  126 => 95,  124 => 94,  119 => 92,  116 => 91,  114 => 83,  113 => 82,  109 => 80,  107 => 76,  106 => 71,  102 => 69,  100 => 64,  99 => 62,  98 => 61,  97 => 59,  93 => 57,  91 => 54,  90 => 52,  89 => 50,  88 => 49,  87 => 47,  78 => 40,  66 => 39,  59 => 38,  54 => 33,  52 => 36,  50 => 35,  48 => 34,  41 => 33,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/webhook/webhooktest.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\webhook\\webhooktest.html.twig");
    }
}
