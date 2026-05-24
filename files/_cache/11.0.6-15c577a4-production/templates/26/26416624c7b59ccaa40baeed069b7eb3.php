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

/* pages/setup/oauthclient.html.twig */
class __TwigTemplate_6a30fd5a09e90be5076727737b5ba924 extends Template
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
            'form_fields' => [$this, 'block_form_fields'],
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
<div class=\"asset\">
    ";
        // line 36
        yield Twig\Extension\CoreExtension::include($this->env, $context, "components/form/header.html.twig");
        yield "

    ";
        // line 38
        $context["rand"] = Twig\Extension\CoreExtension::random($this->env->getCharset());
        // line 39
        yield "    ";
        $context["params"] = (((array_key_exists("params", $context) &&  !(null === $context["params"]))) ? ($context["params"]) : ([]));
        // line 40
        yield "    ";
        $context["field_options"] = [];
        // line 41
        yield "
    <div class=\"card-body d-flex flex-wrap\">
        <div class=\"col-12 col-xxl-12 flex-column\">
            <div class=\"d-flex flex-row flex-wrap flex-xl-nowrap\">
                <div class=\"row flex-row align-items-start flex-grow-1\">
                    <div class=\"row flex-row\">
                        ";
        // line 47
        yield from $this->unwrap()->yieldBlock('form_fields', $context, $blocks);
        // line 137
        yield "                    </div> ";
        // line 138
        yield "                </div> ";
        // line 139
        yield "            </div> ";
        // line 140
        yield "        </div>
    </div> ";
        // line 142
        yield "
    ";
        // line 143
        yield Twig\Extension\CoreExtension::include($this->env, $context, "components/form/buttons.html.twig");
        yield "
</div>
";
        yield from [];
    }

    // line 47
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_form_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 48
        yield "                            ";
        yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 48, $this->getSourceContext())->macro_textField(...["name", (($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 48)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["name"] ?? null) : null), __("Name")]);
        yield "
                            ";
        // line 49
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownArrayField", $context, 49, $this->getSourceContext())->macro_dropdownArrayField(...["grants", null, ["password" => __("Password"), "client_credentials" => __("Client credentials"), "authorization_code" => __("Authorization code")], __("Grants"), ["multiple" => true, "values" => ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source,         // line 55
($context["item"] ?? null), "fields", [], "any", false, true, false, 55), "grants", [], "array", true, true, false, 55)) ? (Twig\Extension\CoreExtension::default((($_v1 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 55)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["grants"] ?? null) : null), ["authorization_code"])) : (["authorization_code"]))]]);
        // line 56
        yield "
                            ";
        // line 57
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "isNewItem", [], "method", false, false, false, 57)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 58
            yield "                                ";
            yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 58, $this->getSourceContext())->macro_textField(...["identifier", (($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 58)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2["identifier"] ?? null) : null), __("Client ID"), ["readonly" => true, "is_copyable" => true]]);
            // line 61
            yield "
                            ";
        }
        // line 63
        yield "                            ";
        if ((array_key_exists("allowed_scopes", $context) &&  !Twig\Extension\CoreExtension::testEmpty(($context["allowed_scopes"] ?? null)))) {
            // line 64
            yield "                                ";
            yield $macros["fields"]->getTemplateForMacro("macro_dropdownArrayField", $context, 64, $this->getSourceContext())->macro_dropdownArrayField(...["scopes", null, ($context["allowed_scopes"] ?? null), __("Scopes"), ["multiple" => true, "values" => (($_v3 = CoreExtension::getAttribute($this->env, $this->source,             // line 66
($context["item"] ?? null), "fields", [], "any", false, false, false, 66)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3["scopes"] ?? null) : null)]]);
            // line 67
            yield "
                            ";
        } else {
            // line 69
            yield "                                ";
            yield $macros["fields"]->getTemplateForMacro("macro_nullField", $context, 69, $this->getSourceContext())->macro_nullField(...[]);
            yield "
                            ";
        }
        // line 71
        yield "                            ";
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "isNewItem", [], "method", false, false, false, 71)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 72
            yield "                                ";
            yield $macros["fields"]->getTemplateForMacro("macro_passwordField", $context, 72, $this->getSourceContext())->macro_passwordField(...["secret", (($_v4 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 72)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4["secret"] ?? null) : null), __("Client Secret"), ["is_disclosable" => true, "readonly" => true]]);
            // line 75
            yield "
                            ";
        }
        // line 77
        yield "
                            ";
        // line 78
        yield $macros["fields"]->getTemplateForMacro("macro_textareaField", $context, 78, $this->getSourceContext())->macro_textareaField(...["comment", (($_v5 = CoreExtension::getAttribute($this->env, $this->source,         // line 80
($context["item"] ?? null), "fields", [], "any", false, false, false, 80)) && is_array($_v5) || $_v5 instanceof ArrayAccess ? ($_v5["comment"] ?? null) : null), _n("Comment", "Comments", Session::getPluralNumber()),         // line 82
($context["field_options"] ?? null)]);
        // line 83
        yield "

                            ";
        // line 85
        yield $macros["fields"]->getTemplateForMacro("macro_smallTitle", $context, 85, $this->getSourceContext())->macro_smallTitle(...[__("Authorized redirect URIs"), "ti ti-forms", __("Only applies to Authorization Code grants")]);
        yield "
                            ";
        // line 86
        $context["authorized_uri_field"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 87
            yield "                                <template id=\"authorized-uri-fields-template\">
                                    <div class=\"authorized-uri-field d-flex mb-2\">
                                        ";
            // line 89
            yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 89, $this->getSourceContext())->macro_textField(...["redirect_uri[]", "", "", ["no_label" => true, "mb" => ""]]);
            // line 92
            yield "
                                        <button class=\"btn btn-danger btn-icon\" name=\"remove_header\" type=\"button\" title=\"";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Remove"), "html", null, true);
            yield "\">
                                            <i class=\"ti ti-trash\"></i>
                                        </button>
                                    </div>
                                </template>
                            ";
            yield from [];
        })())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 99
        yield "                            ";
        yield $macros["fields"]->getTemplateForMacro("macro_field", $context, 99, $this->getSourceContext())->macro_field(...["", ($context["authorized_uri_field"] ?? null), "", ["no_label" => true, "field_class" => "col-12 d-flex"]]);
        // line 102
        yield "
                            <div class=\"authorized-uri-fields mb-3\">
                                <button type=\"button\" class=\"btn btn-secondary mt-3\" name=\"add_uri\">
                                    <i class=\"ti ti-plus\"></i>
                                    ";
        // line 106
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Add URI"), "html", null, true);
        yield "
                                </button>
                            </div>
                            <script>
                                \$('button[name=\"add_uri\"]').on('click', () => {
                                    \$('.authorized-uri-fields button[name=\"add_uri\"]').before(\$('#authorized-uri-fields-template').html());
                                });
                                \$('.authorized-uri-fields').on('click', 'button[name=\"remove_header\"]', function() {
                                    \$(this).closest('.authorized-uri-field').remove();
                                });
                                const already_added_uris = ";
        // line 116
        yield json_encode(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, true, false, 116), "redirect_uri", [], "array", true, true, false, 116)) ? (Twig\Extension\CoreExtension::default((($_v6 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 116)) && is_array($_v6) || $_v6 instanceof ArrayAccess ? ($_v6["redirect_uri"] ?? null) : null), [])) : ([])));
        yield ";
                                const global_uris = ['/api.php/oauth2/redirection', '/api.php/swagger-oauth-redirect'];
                                global_uris.forEach((uri) => {
                                    \$('.authorized-uri-fields button[name=\"add_uri\"]').before(\$('#authorized-uri-fields-template').html());
                                    \$('.authorized-uri-field input').last().val(uri);
                                    // Remove delete button and disable input
                                    \$('.authorized-uri-field button[name=\"remove_header\"]').remove();
                                    \$('.authorized-uri-field input').last().prop('disabled', true);
                                });
                                already_added_uris.forEach((uri) => {
                                    \$('.authorized-uri-fields button[name=\"add_uri\"]').before(\$('#authorized-uri-fields-template').html());
                                    \$('.authorized-uri-field input').last().val(uri);
                                });
                            </script>

                            ";
        // line 131
        yield $macros["fields"]->getTemplateForMacro("macro_smallTitle", $context, 131, $this->getSourceContext())->macro_smallTitle(...[__("IP Restrictions"), "ti ti-network", __("Comma separated list of individual IPv4/IPv6 addresses or ranges in CIDR notation. An empty list indicates there are no restrictions.")]);
        yield "
                            ";
        // line 132
        yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 132, $this->getSourceContext())->macro_textField(...["allowed_ips", (($_v7 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 132)) && is_array($_v7) || $_v7 instanceof ArrayAccess ? ($_v7["allowed_ips"] ?? null) : null), null, ["no_label" => true, "field_class" => "col-12 d-flex"]]);
        // line 135
        yield "
                        ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "pages/setup/oauthclient.html.twig";
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
        return array (  231 => 135,  229 => 132,  225 => 131,  207 => 116,  194 => 106,  188 => 102,  185 => 99,  175 => 93,  172 => 92,  170 => 89,  166 => 87,  164 => 86,  160 => 85,  156 => 83,  154 => 82,  153 => 80,  152 => 78,  149 => 77,  145 => 75,  142 => 72,  139 => 71,  133 => 69,  129 => 67,  127 => 66,  125 => 64,  122 => 63,  118 => 61,  115 => 58,  113 => 57,  110 => 56,  108 => 55,  107 => 49,  102 => 48,  95 => 47,  87 => 143,  84 => 142,  81 => 140,  79 => 139,  77 => 138,  75 => 137,  73 => 47,  65 => 41,  62 => 40,  59 => 39,  57 => 38,  52 => 36,  48 => 34,  46 => 33,  43 => 32,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/oauthclient.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\oauthclient.html.twig");
    }
}
