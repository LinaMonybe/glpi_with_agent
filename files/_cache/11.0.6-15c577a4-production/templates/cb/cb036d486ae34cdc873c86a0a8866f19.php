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

/* install/update.invalid_database.html.twig */
class __TwigTemplate_9c6107df885e069b04da3b039415f58c extends Template
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
<div class=\"alert alert-warning\"><strong>";
        // line 33
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["message"] ?? null), "html", null, true);
        yield "</strong></div>

<form action=\"install.php\" method=\"post\" class=\"d-inline\" data-submit-once>
    <button type=\"submit\" name=\"submit\" class=\"btn btn-warning\">
        <i class=\"ti ti-chevron-left me-1 fs-2x alert-icon\"></i>
        ";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Back"), "html", null, true);
        yield "
    </button>

    <input type=\"hidden\" name=\"update\" value=\"yes\" />
    <input type=\"hidden\" name=\"install\" value=\"Etape_2\" />
    <input type=\"hidden\" name=\"db_host\" value=\"";
        // line 43
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["db_host"] ?? null), "html", null, true);
        yield "\" />
    <input type=\"hidden\" name=\"db_user\" value=\"";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["db_user"] ?? null), "html", null, true);
        yield "\" />
    <input type=\"hidden\" name=\"db_pass\" value=\"";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["db_pass"] ?? null), "html", null, true);
        yield "\" />
    <input type=\"hidden\" name=\"_glpi_csrf_token\" value=\"";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Session::getNewCSRFToken(), "html", null, true);
        yield "\" />
</form>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "install/update.invalid_database.html.twig";
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
        return array (  73 => 46,  69 => 45,  65 => 44,  61 => 43,  53 => 38,  45 => 33,  42 => 32,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/update.invalid_database.html.twig", "C:\\wamp64\\www\\glpi\\templates\\install\\update.invalid_database.html.twig");
    }
}
