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

/* pages/setup/webhook/webhook_security.html.twig */
class __TwigTemplate_53945cbe0ebe7e9037ff220fc7fc505b extends Template
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
        $macros["alerts"] = $this->macros["alerts"] = $this->load("components/alerts_macros.html.twig", 35)->unwrap();
        // line 36
        $context["params"] = (((array_key_exists("params", $context) &&  !(null === $context["params"]))) ? ($context["params"]) : ([]));
        // line 37
        $context["rand_field"] = ((array_key_exists("rand", $context)) ? (Twig\Extension\CoreExtension::default(($context["rand"] ?? null), Twig\Extension\CoreExtension::random($this->env->getCharset()))) : (Twig\Extension\CoreExtension::random($this->env->getCharset())));
        // line 33
        $this->parent = $this->load("generic_show_form.html.twig", 33);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 39
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_form_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 40
        yield "    ";
        yield from $this->unwrap()->yieldBlock('more_fields', $context, $blocks);
        yield from [];
    }

    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_more_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 41
        yield "
        ";
        // line 42
        yield $macros["fields"]->getTemplateForMacro("macro_passwordField", $context, 42, $this->getSourceContext())->macro_passwordField(...["secret", (($_v0 = CoreExtension::getAttribute($this->env, $this->source,         // line 44
($context["item"] ?? null), "fields", [], "any", false, false, false, 44)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["secret"] ?? null) : null), __("Secret"), Twig\Extension\CoreExtension::merge(        // line 46
($context["field_options"] ?? null), ["is_disclosable" => true, "can_regenerate" => true, "helper" => __("The webhook secret can be shared with a target server to allow it to validate requests are actually coming from the GLPI server and that the content was not modified between GLPI and the target.")])]);
        // line 51
        yield "

        ";
        // line 53
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownTimestampField", $context, 53, $this->getSourceContext())->macro_dropdownTimestampField(...["expiration", (($_v1 = CoreExtension::getAttribute($this->env, $this->source,         // line 55
($context["item"] ?? null), "fields", [], "any", false, false, false, 55)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["expiration"] ?? null) : null), __("Expiration delay"), Twig\Extension\CoreExtension::merge(        // line 57
($context["field_options"] ?? null), ["emptylabel" => __("Disabled"), "min" => 0, "max" => (Twig\Extension\CoreExtension::constant("HOUR_TIMESTAMP") * 23), "step" => Twig\Extension\CoreExtension::constant("HOUR_TIMESTAMP"), "toadd" => [Twig\Extension\CoreExtension::constant("MINUTE_TIMESTAMP"), (Twig\Extension\CoreExtension::constant("MINUTE_TIMESTAMP") * 2), (Twig\Extension\CoreExtension::constant("MINUTE_TIMESTAMP") * 5), (Twig\Extension\CoreExtension::constant("MINUTE_TIMESTAMP") * 10), (Twig\Extension\CoreExtension::constant("MINUTE_TIMESTAMP") * 15), (Twig\Extension\CoreExtension::constant("MINUTE_TIMESTAMP") * 20), (Twig\Extension\CoreExtension::constant("MINUTE_TIMESTAMP") * 30), Twig\Extension\CoreExtension::constant("HOUR_TIMESTAMP"), (Twig\Extension\CoreExtension::constant("HOUR_TIMESTAMP") * 2), (Twig\Extension\CoreExtension::constant("HOUR_TIMESTAMP") * 6), (Twig\Extension\CoreExtension::constant("HOUR_TIMESTAMP") * 12)], "width" => "auto"])]);
        // line 77
        yield "

        ";
        // line 79
        yield $macros["fields"]->getTemplateForMacro("macro_smallTitle", $context, 79, $this->getSourceContext())->macro_smallTitle(...[__("Target authentication"), "ti ti-fingerprint"]);
        yield "

        ";
        // line 81
        $context["cra_tooltip"] = __("Challenge–response authentication can be used to validate the identity of the target server before any data is sent from GLPI. This uses the shared secret that was generated in the above section.");
        // line 82
        yield "
        ";
        // line 83
        if ((($tmp = Twig\Extension\CoreExtension::constant("GLPI_WEBHOOK_CRA_MANDATORY")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 84
            yield "            ";
            yield $macros["alerts"]->getTemplateForMacro("macro_alert_info", $context, 84, $this->getSourceContext())->macro_alert_info(...[__("CRA is mandatory due to GLPI configuration"), [($context["cra_tooltip"] ?? null)]]);
            yield "
            <input type=\"hidden\" name=\"use_cra_challenge\" value=\"1\" />
        ";
        } else {
            // line 87
            yield "            ";
            yield $macros["fields"]->getTemplateForMacro("macro_checkboxField", $context, 87, $this->getSourceContext())->macro_checkboxField(...["use_cra_challenge", (($_v2 = CoreExtension::getAttribute($this->env, $this->source,             // line 89
($context["item"] ?? null), "fields", [], "any", false, false, false, 89)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2["use_cra_challenge"] ?? null) : null), __("Use CRA Challenge?"), Twig\Extension\CoreExtension::merge(            // line 91
($context["field_options"] ?? null), ["helper" => __("Challenge–response authentication can be used to validate the identity of the target server before any data is sent from GLPI. This uses the shared secret that was generated in the above section.")])]);
            // line 94
            yield "
        ";
        }
        // line 96
        yield "
        ";
        // line 97
        $context["cra_btn"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 98
            yield "            <button class=\"btn btn-primary me-2\" type=\"button\" name=\"validate_challenge\" value=\"1\">
                <i class=\"ti ti-lock-check\"></i>
                <span>";
            // line 100
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(_x("button", "Validate"), "html", null, true);
            yield "</span>
            </button>
        ";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 103
        yield "
        ";
        // line 104
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 104, $this->getSourceContext())->macro_htmlField(...["",         // line 106
($context["cra_btn"] ?? null), __("CRA Challenge"), Twig\Extension\CoreExtension::merge(        // line 108
($context["field_options"] ?? null), ["add_field_class" => (((($tmp = (($_v3 = CoreExtension::getAttribute($this->env, $this->source,         // line 109
($context["item"] ?? null), "fields", [], "any", false, false, false, 109)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3["use_cra_challenge"] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("d-none"))])]);
        // line 111
        yield "

        ";
        // line 113
        $context["cra_challenge_infi"] = new Markup("            <span name=\"cra_result\">
         </span>
        ", $this->env->getCharset());
        // line 117
        yield "
        ";
        // line 118
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 118, $this->getSourceContext())->macro_htmlField(...["",         // line 120
($context["cra_challenge_infi"] ?? null), __("CRA result"), Twig\Extension\CoreExtension::merge(        // line 122
($context["field_options"] ?? null), ["add_field_class" => (((($tmp = (($_v4 = CoreExtension::getAttribute($this->env, $this->source,         // line 123
($context["item"] ?? null), "fields", [], "any", false, false, false, 123)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4["use_cra_challenge"] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("d-none"))])]);
        // line 125
        yield "

        ";
        // line 127
        yield $macros["fields"]->getTemplateForMacro("macro_smallTitle", $context, 127, $this->getSourceContext())->macro_smallTitle(...[__("OAuth Authentication"), "ti ti-key"]);
        yield "
        ";
        // line 128
        yield $macros["fields"]->getTemplateForMacro("macro_checkboxField", $context, 128, $this->getSourceContext())->macro_checkboxField(...["use_oauth", (($_v5 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 128)) && is_array($_v5) || $_v5 instanceof ArrayAccess ? ($_v5["use_oauth"] ?? null) : null), __("Use OAuth")]);
        yield "
        ";
        // line 129
        yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 129, $this->getSourceContext())->macro_textField(...["oauth_url", (($_v6 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 129)) && is_array($_v6) || $_v6 instanceof ArrayAccess ? ($_v6["oauth_url"] ?? null) : null), __("URL")]);
        yield "
        ";
        // line 130
        yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 130, $this->getSourceContext())->macro_textField(...["clientid", (($_v7 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 130)) && is_array($_v7) || $_v7 instanceof ArrayAccess ? ($_v7["clientid"] ?? null) : null), __("Client ID")]);
        yield "
        ";
        // line 132
        yield "        ";
        yield $macros["fields"]->getTemplateForMacro("macro_passwordField", $context, 132, $this->getSourceContext())->macro_passwordField(...["clientsecret", (($_v8 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 132)) && is_array($_v8) || $_v8 instanceof ArrayAccess ? ($_v8["clientsecret"] ?? null) : null), __("Client Secret"), ["is_disclosable" => true, "readonly" => true, "additional_attributes" => ["autocomplete" => "off", "onfocus" => "this.removeAttribute(\"readonly\");"]]]);
        // line 139
        yield "

        <script>
            \$('input[name=\"use_cra_challenge\"]').change(function () {
                if (\$('input[name=\"use_cra_challenge\"]').is(\":checked\")) {
                    \$('button[name=\"validate_challenge\"]').parent().parent().parent().removeClass('d-none');
                    \$('span[name=\"cra_result\"]').parent().parent().parent().removeClass('d-none');
                    \$('button[name=\"validate_challenge\"]').trigger('click');
                } else {
                    \$('button[name=\"validate_challenge\"]').parent().parent().parent().addClass('d-none');
                    \$('span[name=\"cra_result\"]').parent().parent().parent().addClass('d-none');
                }
            });

            \$('button[name=\"validate_challenge\"]').click(function () {
                secret = \$('input[name=\"secret\"]').val();

                \$.ajax({
                    type: 'POST',
                    url: '";
        // line 158
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Glpi\Application\View\Extension\RoutingExtension']->path("/ajax/webhook.php"), "html", null, true);
        yield "',
                    data: {
                        action: 'valide_cra_challenge',
                        webhook_id: ";
        // line 161
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((($_v9 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 161)) && is_array($_v9) || $_v9 instanceof ArrayAccess ? ($_v9["id"] ?? null) : null), "html", null, true);
        yield ",
                        secret: secret,
                    },
                    success: function(json_response) {
                        if (json_response.status) {
                            \$('input[name=\"is_cra_challenge_valid\"]').val(1);
                            \$('span[name=\"cra_result\"]').html('<i class=\"ti ti-circle-check icon-pulse fs-2\" style=\"color: #36d601;\"></i> ' + (json_response.status_code ? json_response.status_code + ' ' : ' ') + json_response.message);
                        } else {
                            \$('input[name=\"is_cra_challenge_valid\"]').val(0);
                            \$('span[name=\"cra_result\"]').html('<i class=\"ti ti-alert-triangle icon-pulse fs-2\" style=\"color: #ff0000;\"></i> ' + (json_response.status_code ? json_response.status_code + ' ' : ' ') + json_response.message);
                        }
                    },
                });
            });

            \$(function() {
                if (\$('input[name=\"use_cra_challenge\"]').is(\":checked\") ) {
                    \$('button[name=\"validate_challenge\"]').click();
                }
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
        return "pages/setup/webhook/webhook_security.html.twig";
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
        return array (  217 => 161,  211 => 158,  190 => 139,  187 => 132,  183 => 130,  179 => 129,  175 => 128,  171 => 127,  167 => 125,  165 => 123,  164 => 122,  163 => 120,  162 => 118,  159 => 117,  155 => 113,  151 => 111,  149 => 109,  148 => 108,  147 => 106,  146 => 104,  143 => 103,  136 => 100,  132 => 98,  130 => 97,  127 => 96,  123 => 94,  121 => 91,  120 => 89,  118 => 87,  111 => 84,  109 => 83,  106 => 82,  104 => 81,  99 => 79,  95 => 77,  93 => 57,  92 => 55,  91 => 53,  87 => 51,  85 => 46,  84 => 44,  83 => 42,  80 => 41,  68 => 40,  61 => 39,  56 => 33,  54 => 37,  52 => 36,  50 => 35,  48 => 34,  41 => 33,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/webhook/webhook_security.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\webhook\\webhook_security.html.twig");
    }
}
