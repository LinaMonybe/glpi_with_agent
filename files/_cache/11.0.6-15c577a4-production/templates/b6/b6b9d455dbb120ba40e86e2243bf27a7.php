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

/* pages/admin/form/question_type/item/end_user_template.html.twig */
class __TwigTemplate_bf81ead57855b3acf897d11ce301cf3b extends Template
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
";
        // line 35
        yield $macros["fields"]->getTemplateForMacro("macro_hiddenField", $context, 35, $this->getSourceContext())->macro_hiddenField(...[(CoreExtension::getAttribute($this->env, $this->source,         // line 36
($context["question"] ?? null), "getEndUserInputName", [], "method", false, false, false, 36) . "[itemtype]"),         // line 37
($context["itemtype"] ?? null)]);
        // line 38
        yield "
";
        // line 40
        $context["dropdown_options"] = ["no_label" => true, "right" => "all", "aria_label" =>         // line 43
($context["aria_label"] ?? null), "mb" => "", "addicon" => false, "comments" => false, "condition" =>         // line 47
($context["dropdown_restriction_params"] ?? null), "nochecklimit" => true, "display_emptychoice" => false, "toadd" => ["-1" => Twig\Extension\CoreExtension::constant("Dropdown::EMPTY_VALUE")]];
        // line 54
        yield "
";
        // line 56
        if ((($tmp =  !Twig\Extension\CoreExtension::testEmpty(($context["displaywith"] ?? null))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 57
            yield "    ";
            $context["dropdown_options"] = Twig\Extension\CoreExtension::merge(($context["dropdown_options"] ?? null), ["displaywith" => ($context["displaywith"] ?? null)]);
        }
        // line 59
        yield "
";
        // line 60
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownField", $context, 60, $this->getSourceContext())->macro_dropdownField(...[        // line 61
($context["itemtype"] ?? null), (CoreExtension::getAttribute($this->env, $this->source,         // line 62
($context["question"] ?? null), "getEndUserInputName", [], "method", false, false, false, 62) . "[items_id]"),         // line 63
($context["default_items_id"] ?? null), "",         // line 65
($context["dropdown_options"] ?? null)]);
        // line 66
        yield "
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "pages/admin/form/question_type/item/end_user_template.html.twig";
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
        return array (  79 => 66,  77 => 65,  76 => 63,  75 => 62,  74 => 61,  73 => 60,  70 => 59,  66 => 57,  64 => 56,  61 => 54,  59 => 47,  58 => 43,  57 => 40,  54 => 38,  52 => 37,  51 => 36,  50 => 35,  47 => 34,  45 => 33,  42 => 32,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/admin/form/question_type/item/end_user_template.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\admin\\form\\question_type\\item\\end_user_template.html.twig");
    }
}
