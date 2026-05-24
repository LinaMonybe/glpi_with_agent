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

/* pages/setup/notification/notification_notificationtemplate.html.twig */
class __TwigTemplate_6361f675ab6c1231f29e365fd7c70686 extends Template
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
        $macros["inputs"] = $this->macros["inputs"] = $this->load("components/form/basic_inputs_macros.html.twig", 35)->unwrap();
        // line 33
        $this->parent = $this->load("generic_show_form.html.twig", 33);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 37
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_form_fields(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 38
        yield "\t";
        yield $macros["inputs"]->getTemplateForMacro("macro_hidden", $context, 38, $this->getSourceContext())->macro_hidden(...["notifications_id", (($_v0 = CoreExtension::getAttribute($this->env, $this->source, ($context["notification"] ?? null), "fields", [], "any", false, false, false, 38)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0["id"] ?? null) : null)]);
        yield "
   ";
        // line 39
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 39, $this->getSourceContext())->macro_htmlField(...["", ($context["notification_link"] ?? null), $this->extensions['Glpi\Application\View\Extension\ItemtypeExtension']->getItemtypeName("Notification")]);
        yield "
   ";
        // line 40
        yield $macros["fields"]->getTemplateForMacro("macro_nullField", $context, 40, $this->getSourceContext())->macro_nullField(...[]);
        yield "
   ";
        // line 41
        yield $macros["fields"]->getTemplateForMacro("macro_htmlField", $context, 41, $this->getSourceContext())->macro_htmlField(...["", $this->extensions['Glpi\Application\View\Extension\PhpExtension']->call("Notification_NotificationTemplate::dropdownMode", [["name" => "mode", "value" => (($_v1 = CoreExtension::getAttribute($this->env, $this->source,         // line 43
($context["item"] ?? null), "fields", [], "any", false, false, false, 43)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1["mode"] ?? null) : null), "display" => false]]), __("Mode")]);
        // line 45
        yield "
   ";
        // line 46
        yield $macros["fields"]->getTemplateForMacro("macro_dropdownField", $context, 46, $this->getSourceContext())->macro_dropdownField(...["NotificationTemplate", "notificationtemplates_id", (($_v2 = CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "fields", [], "any", false, false, false, 46)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2["notificationtemplates_id"] ?? null) : null), $this->extensions['Glpi\Application\View\Extension\ItemtypeExtension']->getItemtypeName("NotificationTemplate"), ["comment" => 1, "condition" => ["itemtype" => (($_v3 = CoreExtension::getAttribute($this->env, $this->source,         // line 49
($context["notification"] ?? null), "fields", [], "any", false, false, false, 49)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3["itemtype"] ?? null) : null)]]]);
        // line 51
        yield "
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "pages/setup/notification/notification_notificationtemplate.html.twig";
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
        return array (  85 => 51,  83 => 49,  82 => 46,  79 => 45,  77 => 43,  76 => 41,  72 => 40,  68 => 39,  63 => 38,  56 => 37,  51 => 33,  49 => 35,  47 => 34,  40 => 33,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "pages/setup/notification/notification_notificationtemplate.html.twig", "C:\\wamp64\\www\\glpi\\templates\\pages\\setup\\notification\\notification_notificationtemplate.html.twig");
    }
}
