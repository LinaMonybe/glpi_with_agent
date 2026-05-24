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

/* components/search/criteria_filter_actions.html.twig */
class __TwigTemplate_ea07f9de67e6b7e4f64ef132eb6bb88b extends Template
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
<div class=\"ms-2\">
    <button
        class=\"btn btn-primary me-1 ";
        // line 35
        yield (((($tmp = ($context["show_save"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("d-none"));
        yield "\"
        type=\"submit\"
        name=\"save_filters\"
    >
        <i class=\"ti ti-device-floppy\"></i>
        <span class=\"spinner-border spinner-border-sm d-none\" role=\"status\" aria-hidden=\"true\"></span>
        <span class=\"d-none d-sm-block\">";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Save"), "html", null, true);
        yield "</span>
    </button>

    <button
        class=\"btn btn-outline-danger me-1 ";
        // line 45
        yield (((($tmp = ($context["show_delete"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("") : ("d-none"));
        yield "\"
        name=\"delete_filters\"
    >
        <i class=\"ti ti-trash\"></i>
        <span class=\"spinner-border spinner-border-sm d-none\" role=\"status\" aria-hidden=\"true\"></span>
        <span class=\"d-none d-sm-block\">";
        // line 50
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Delete"), "html", null, true);
        yield "</span>
    </button>
</div>

<script type=\"module\">
    function showLoading(btn) {
        btn.find('i').addClass('d-none');
        btn.find('.spinner-border').removeClass('d-none');
        // Disable this and sibling buttons
        btn.prop('disabled', true);
        btn.siblings('button').prop('disabled', true);
    }

    function hideLoading(btn) {
        btn.find('i').removeClass('d-none');
        btn.find('.spinner-border').addClass('d-none');
        // Enable this and sibling buttons
        btn.prop('disabled', false);
        btn.siblings('button').prop('disabled', false);
    }

    // Save action
    \$(\"button[name='save_filters']\").on(\"click\", (e) => {
        // Prevent form submit
        e.preventDefault();

        const btn = \$(e.currentTarget);

        // Find form
        const form = btn.closest('form');

        showLoading(btn);

        // Save results
        const form_data = new FormData(form[0]);

        // Add references to parent item, must be prefixed by \"item_\" because
        // \"itemtype\" will already be set by the search's form
        form_data.append('item_itemtype', \"";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["itemtype"] ?? null), "html", null, true);
        yield "\");
        form_data.append('item_items_id', ";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["items_id"] ?? null), "html", null, true);
        yield ");

        // Endpoint
        form_data.append('action', \"save_filter\");

        // Send data to backend
        \$.ajax({
            type: \"POST\",
            url: CFG_GLPI.root_doc + \"/ajax/criteria_filter.php\",
            data: form_data,
            processData: false, // Needed when using FormData object
            contentType: false, // Needed when using FormData object
        }).done(function() {
            glpi_toast_info(\"";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Filter saved"), "html", null, true);
        yield "\");
    ";
        // line 103
        if (array_key_exists("delete_action_id", $context)) {
            // line 104
            yield "            // Show delete button if it wasn't already enabled
            \$(\"#";
            // line 105
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["delete_action_id"] ?? null), "html", null, true);
            yield "\").removeClass('d-none');
    ";
        }
        // line 107
        yield "
            // Add badge to menu to hint that a filter have been set
            const tab = \$(\"a.nav-link[href*='CriteriaFilter']\");
            if (tab.find('span.badge').length == 0) {
                tab.append('<span class=\"badge\">1</span>');
            }
        }).fail(function() {
            glpi_toast_error(\"";
        // line 114
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Unable to save filter"), "html", null, true);
        yield "\");
        }).always(function() {
            hideLoading(btn);
        });

        // Hide preview since its content may not match the saved value
        \$(\"#criteria_filter_preview\").addClass(\"d-none\");
    });

    // Delete action
    \$(\"button[name='delete_filters']\").on(\"click\", (e) => {
        // Prevent form submit
        e.preventDefault();

        const btn = \$(e.currentTarget);
        showLoading(btn);

        \$.ajax({
            type: \"POST\",
            url: CFG_GLPI.root_doc + \"/ajax/criteria_filter.php\",
            data: {
                'action': 'delete_filter',
                'itemtype': '";
        // line 136
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["itemtype"] ?? null), "html", null, true);
        yield "',
                'items_id': ";
        // line 137
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["items_id"] ?? null), "html", null, true);
        yield ",
            },
        }).done(function() {
            // Reload page, easiest way to clear search UI
            location.reload();
        }).fail(function() {
            hideLoading(btn);

            glpi_toast_error(\"";
        // line 145
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(__("Failed to delete filter"), "html", null, true);
        yield "\");
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
        return "components/search/criteria_filter_actions.html.twig";
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
        return array (  195 => 145,  184 => 137,  180 => 136,  155 => 114,  146 => 107,  141 => 105,  138 => 104,  136 => 103,  132 => 102,  116 => 89,  112 => 88,  71 => 50,  63 => 45,  56 => 41,  47 => 35,  42 => 32,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "components/search/criteria_filter_actions.html.twig", "C:\\wamp64\\www\\glpi\\templates\\components\\search\\criteria_filter_actions.html.twig");
    }
}
