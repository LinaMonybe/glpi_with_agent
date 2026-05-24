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

/* components/plugin_update_modal.html.twig */
class __TwigTemplate_09f78cb947f21e29895d32240823b9f5 extends Template
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
<!-- Button trigger modal -->
";
        // line 34
        yield ($context["open_btn"] ?? null);
        yield "

<!-- Modal -->
<div class=\"modal fade\" id=\"";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["modal_id"] ?? null), "html", null, true);
        yield "\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <a type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></a>
            <div class=\"modal-status bg-info\"></div>
            <div
                class=\"modal-body text-center py-4\">
                <i class=\"fa-2x ti ti-info-circle mb-2 text-info\"></i>
                <h3>";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(_x("button", "Update?"), "html", null, true);
        yield "</h3>
                <div class=\"text-muted\">";
        // line 46
        yield Twig\Extension\CoreExtension::sprintf($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("A new update is available for the %s plugin.")), (("<strong>" . $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["plugin_name"] ?? null))) . "</strong>"));
        yield "</div>
                <div class=\"text-muted\">";
        // line 47
        yield Twig\Extension\CoreExtension::sprintf($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Update to version %s?")), (("<strong><code>" . $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["to_version"] ?? null))) . "</strong></code>"));
        yield "</div>
            </div>
            <div class=\"modal-footer\">
                <div class=\"w-100\">
                    <div class=\"row\">
                        <div class=\"col\">
                            <a class=\"btn w-100\" data-bs-dismiss=\"modal\">
                                ";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Cancel"), "html", null, true);
        yield "
                            </a>
                        </div>
                        <div class=\"col\">
                            ";
        // line 58
        yield ($context["update_btn"] ?? null);
        yield "
                        </div>
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
        return "components/plugin_update_modal.html.twig";
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
        return array (  88 => 58,  81 => 54,  71 => 47,  67 => 46,  63 => 45,  52 => 37,  46 => 34,  42 => 32,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "components/plugin_update_modal.html.twig", "C:\\wamp64\\www\\glpi\\templates\\components\\plugin_update_modal.html.twig");
    }
}
