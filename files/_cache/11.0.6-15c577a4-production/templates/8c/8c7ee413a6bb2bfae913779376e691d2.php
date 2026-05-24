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

/* pages/setup/webhook/queuedwebhook.html.twig */
class __TwigTemplate_1c8b2e6a21410361b7e53c40747667fa extends Template
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
        // line 38
        $context["params"] = Twig\Extension\CoreExtension::merge(($context["params"] ?? null), ["addbuttons" => ["send" => ["icon" => "ti ti-send", "text" => ((((null === (($_v0 = CoreExtension::getAttribute($this->env, $this->source,         // line 42
($context["item"] ?? null), "fields", [], "any", false, false, false, 42)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["last_status_code"] ?? null) : null)) || ((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 42)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["last_status_code"] ?? null) : null) >= 300))) ? (__("Send")) : (__("Resend"))), "type" => "button"]]]);
        // line 33
        $this->parent = $this->load("generic_show_form.html.twig", 33);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 48
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_form_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 49
        yield "    ";
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 49, $this->getSourceContext())->macro_htmlField(...["itemtype", $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 49)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2["itemtype"] ?? null) : null)), _n("Type", "Types", 1)]);
        yield "
    ";
        // line 50
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 50, $this->getSourceContext())->macro_htmlField(...["items_id", $this->extensions['Glpi\Application\View\Extension\ItemtypeExtension']->getItemLink((($_v3 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 50)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3["itemtype"] ?? null) : null), (($_v4 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 50)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4["items_id"] ?? null) : null)), _n("Item", "Items", 1)]);
        yield "
    ";
        // line 51
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 51, $this->getSourceContext())->macro_htmlField(...["webhooks_id", $this->extensions['Glpi\Application\View\Extension\ItemtypeExtension']->getItemLink(($context["webhook"] ?? null)), $this->extensions['Glpi\Application\View\Extension\ItemtypeExtension']->getItemtypeName("Webhook")]);
        yield "
    ";
        // line 52
        yield $macros["fields"]->getTemplateForMacro("macro_nullField", $context, 52, $this->getSourceContext())->macro_nullField(...[]);
        yield "
    ";
        // line 53
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 53, $this->getSourceContext())->macro_htmlField(...["create_time", $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v5 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 53)) && is_array($_v5) || $_v5 instanceof ArrayAccess ? ($_v5["create_time"] ?? null) : null)), __("Creation date")]);
        yield "
    ";
        // line 54
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 54, $this->getSourceContext())->macro_htmlField(...["send_time", $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v6 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 54)) && is_array($_v6) || $_v6 instanceof ArrayAccess ? ($_v6["send_time"] ?? null) : null)), __("Expected send date")]);
        yield "
    ";
        // line 55
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 55, $this->getSourceContext())->macro_htmlField(...["sent_time", $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v7 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 55)) && is_array($_v7) || $_v7 instanceof ArrayAccess ? ($_v7["sent_time"] ?? null) : null)), __("Send date")]);
        yield "
    ";
        // line 56
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 56, $this->getSourceContext())->macro_htmlField(...["sent_try", $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v8 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 56)) && is_array($_v8) || $_v8 instanceof ArrayAccess ? ($_v8["sent_try"] ?? null) : null)), __("Number of tries of sent")]);
        yield "
    ";
        // line 57
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 57, $this->getSourceContext())->macro_htmlField(...["last_status_code", CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "getStatusCodeBadge", [(($_v9 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 57)) && is_array($_v9) || $_v9 instanceof ArrayAccess ? ($_v9["last_status_code"] ?? null) : null)], "method", false, false, false, 57), __("Last status code")]);
        yield "

    ";
        // line 59
        yield $macros["fields"]->getTemplateForMacro("macro_smallTitle", $context, 59, $this->getSourceContext())->macro_smallTitle(...[__("Request")]);
        yield "

    ";
        // line 61
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 61, $this->getSourceContext())->macro_htmlField(...["url", $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v10 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 61)) && is_array($_v10) || $_v10 instanceof ArrayAccess ? ($_v10["url"] ?? null) : null)), __("URL")]);
        yield "
    ";
        // line 62
        yield $macros["fields"]->getTemplateForMacro("macro_textareaField", $context, 62, $this->getSourceContext())->macro_textareaField(...["body", $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v11 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 62)) && is_array($_v11) || $_v11 instanceof ArrayAccess ? ($_v11["body"] ?? null) : null)), "", ["full_width" => true, "readonly" => true, "rows" => 10, "no_label" => true]]);
        // line 67
        yield "

    ";
        // line 69
        yield $macros["fields"]->getTemplateForMacro("macro_smallTitle", $context, 69, $this->getSourceContext())->macro_smallTitle(...[__("Headers")]);
        yield "
    ";
        // line 70
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["headers"] ?? null));
        foreach ($context['_seq'] as $context["header_name"] => $context["header_value"]) {
            // line 71
            yield "        ";
            yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 71, $this->getSourceContext())->macro_htmlField(...[("headers_" . $context["header_name"]), $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["header_value"]), $context["header_name"]]);
            yield "
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['header_name'], $context['header_value'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 73
        yield "
    ";
        // line 74
        if ((($tmp = Twig\Extension\CoreExtension::constant("GLPI_WEBHOOK_ALLOW_RESPONSE_SAVING")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 75
            yield "        ";
            yield $macros["fields"]->getTemplateForMacro("macro_smallTitle", $context, 75, $this->getSourceContext())->macro_smallTitle(...[__("Last response")]);
            yield "
        ";
            // line 76
            yield $macros["fields"]->getTemplateForMacro("macro_textareaField", $context, 76, $this->getSourceContext())->macro_textareaField(...["response_body", (($_v12 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 76)) && is_array($_v12) || $_v12 instanceof ArrayAccess ? ($_v12["response_body"] ?? null) : null), "", ["full_width" => true, "readonly" => true, "rows" => 10, "no_label" => true]]);
            // line 81
            yield "
    ";
        }
        // line 83
        yield "
    <script>
        \$(() => {
            \$('button[name=\"send\"]').click((e) => {
                const btn = \$(e.target);
                \$.ajax({
                    url: '";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Glpi\Application\View\Extension\RoutingExtension']->path("/ajax/webhook.php"), "html", null, true);
        yield "',
                    type: 'POST',
                    data: {
                        'action': 'resend',
                        'id': ";
        // line 93
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v13 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 93)) && is_array($_v13) || $_v13 instanceof ArrayAccess ? ($_v13["id"] ?? null) : null), "html", null, true);
        yield "
                    },
                    beforeSend: () => {
                        btn.attr('disabled', true);
                    },
                    complete: () => {
                        window.location.reload();
                    }
                });
            });
        })
    </script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "pages/setup/webhook/queuedwebhook.html.twig";
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
        return array (  169 => 93,  162 => 89,  154 => 83,  150 => 81,  148 => 76,  143 => 75,  141 => 74,  138 => 73,  129 => 71,  125 => 70,  121 => 69,  117 => 67,  115 => 62,  111 => 61,  106 => 59,  101 => 57,  97 => 56,  93 => 55,  89 => 54,  85 => 53,  81 => 52,  77 => 51,  73 => 50,  68 => 49,  61 => 48,  56 => 33,  54 => 42,  53 => 38,  51 => 36,  49 => 35,  47 => 34,  40 => 33,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/webhook/queuedwebhook.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\webhook\\queuedwebhook.html.twig");
    }
}
