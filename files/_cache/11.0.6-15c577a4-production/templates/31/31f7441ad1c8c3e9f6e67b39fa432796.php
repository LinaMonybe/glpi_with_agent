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

/* pages/setup/notification/ajax_setting.html.twig */
class __TwigTemplate_f7300c7935a89744f0a4b6cf20b41b20 extends Template
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
        // line 33
        $this->parent = $this->load("generic_show_form.html.twig", 33);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 36
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_form_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 37
        yield "    ";
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownArrayField", $context, 37, $this->getSourceContext())->macro_dropdownArrayField(...["notifications_ajax_sound", $this->extensions['Glpi\Application\View\Extension\ConfigExtension']->config("notifications_ajax_sound"), ["sound_a" => (__("Sound") . " A"), "sound_b" => (__("Sound") . " B"), "sound_c" => (__("Sound") . " C"), "sound_d" => (__("Sound") . " D")], __("Default notification sound"), ["display_emptychoice" => true, "emptylabel" => __("Disabled")]]);
        // line 45
        yield "

    ";
        // line 47
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownNumberField", $context, 47, $this->getSourceContext())->macro_dropdownNumberField(...["notifications_ajax_check_interval", $this->extensions['Glpi\Application\View\Extension\ConfigExtension']->config("notifications_ajax_check_interval"), __("Time to check for new notifications (in seconds)"), ["min" => 5, "max" => 120, "step" => 5]]);
        // line 51
        yield "

    ";
        // line 53
        yield $macros["fields"]->getTemplateForMacro("macro_textField", $context, 53, $this->getSourceContext())->macro_textField(...["notifications_ajax_icon_url", $this->extensions['Glpi\Application\View\Extension\ConfigExtension']->config("notifications_ajax_icon_url"), __("URL of the icon"), ["additional_attributes" => ["placeholder" => $this->extensions['Glpi\Application\View\Extension\RoutingExtension']->path("pics/glpi.png")]]]);
        // line 57
        yield "

    ";
        // line 59
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownNumberField", $context, 59, $this->getSourceContext())->macro_dropdownNumberField(...["notifications_ajax_expiration_delay", $this->extensions['Glpi\Application\View\Extension\ConfigExtension']->config("notifications_ajax_expiration_delay"), __("Validity period of notifications (in days)"), ["helper" => Twig\Extension\CoreExtension::sprintf(__("Notifications older than the selected value will not be displayed. Expired notifications will be deleted by the %s crontask."),         // line 60
($context["stale_crontask_name"] ?? null)), "toadd" => [__("Unlimited")]]]);
        // line 64
        yield "
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "pages/setup/notification/ajax_setting.html.twig";
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
        return array (  83 => 64,  81 => 60,  80 => 59,  76 => 57,  74 => 53,  70 => 51,  68 => 47,  64 => 45,  61 => 37,  54 => 36,  49 => 33,  47 => 34,  40 => 33,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/notification/ajax_setting.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\notification\\ajax_setting.html.twig");
    }
}
