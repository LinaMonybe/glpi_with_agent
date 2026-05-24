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

/* components/search/criteria_filter.html.twig */
class __TwigTemplate_08dbf6829bccfb47d0fae1a4125c7450 extends Template
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
        // line 34
        yield "<div class=\"row\">
    ";
        // line 36
        yield "    <div class=\"col-12 search-container container\">
        ";
        // line 38
        yield "        <div class=\"alert alert-info mt-1\">
            <h3 class=\"fw-normal\"><i class=\"ti ti-info-circle me-1\"></i>";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["info_title"] ?? null), "html", null, true);
        yield "</h3>
            <p class=\"text-muted\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["info_description"] ?? null), "html", null, true);
        yield "</p>
        </div>

        ";
        // line 44
        yield "        <div id=\"manage_filter_ux\" class=\"";
        yield (((($tmp = ($context["filter_enabled"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("d-none"));
        yield "\">

            ";
        // line 47
        yield "            ";
        $this->extensions['Glpi\Application\View\Extension\PhpExtension']->call("Glpi\\Search\\Input\\QueryBuilder::showGenericSearch", [($context["itemtype"] ?? null), (($context["params"] ?? null) + ["is_criteria_filter" => true])]);
        // line 48
        yield "
            ";
        // line 50
        yield "            <div id=\"criteria_filter_preview\" class=\"d-none\">
                <h2>";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Preview"), "html", null, true);
        yield "</h2>
                ";
        // line 52
        $context["params"] = Twig\Extension\CoreExtension::merge(($context["params"] ?? null), ["execute_search" => false]);
        // line 53
        yield "                ";
        $this->extensions['Glpi\Application\View\Extension\PhpExtension']->call("Glpi\\Search\\SearchEngine::showOutput", [($context["itemtype"] ?? null), ($context["params"] ?? null)]);
        // line 54
        yield "            </div>
        </div>

        ";
        // line 58
        yield "        <div id=\"enable_filter\" class=\"";
        yield (((($tmp = ($context["filter_enabled"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("d-none") : (""));
        yield "\">
            <div class=\"empty align-items-start p-2\">
              <p class=\"empty-title\">";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("No filter found"), "html", null, true);
        yield "</p>
              <p class=\"empty-subtitle text-muted\">";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("There is no filter defined yet for this item."), "html", null, true);
        yield "</p>
              <div class=\"empty-action\">
                <button id=\"enable_filter_action\" type=\"button\" class=\"btn btn-primary\"><i class=\"ti ti-plus me-2\"></i>";
        // line 63
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Create a filter"), "html", null, true);
        yield "</button>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Display search results
    \$('button[name=search]').on('click', function(e) {
        \$(\"#criteria_filter_preview\").removeClass(\"d-none\");
    });

    // Enable filter action
    \$(\"#enable_filter_action\").on('click', function(e) {
        \$(\"#manage_filter_ux\").removeClass(\"d-none\");
        \$(\"#enable_filter\").addClass(\"d-none\");
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
        return "components/search/criteria_filter.html.twig";
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
        return array (  108 => 63,  103 => 61,  99 => 60,  93 => 58,  88 => 54,  85 => 53,  83 => 52,  79 => 51,  76 => 50,  73 => 48,  70 => 47,  64 => 44,  58 => 40,  54 => 39,  51 => 38,  48 => 36,  45 => 34,  42 => 32,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "components/search/criteria_filter.html.twig", "C:\\wamp64\\www\\glpi\\templates\\components\\search\\criteria_filter.html.twig");
    }
}
