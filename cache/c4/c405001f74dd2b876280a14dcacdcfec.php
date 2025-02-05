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

/* base.html.twig */
class __TwigTemplate_74b27c9ff30f12c685f42fc02bc946cb extends Template
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
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"en\">
\t<head>
\t\t<meta charset=\"UTF-8\">
\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
\t\t<title>";
        // line 6
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null), "html", null, true);
        yield "</title>
\t\t<link rel=\"stylesheet\" href=\"/css/styles.css\">
\t</head>
\t<body>
\t\t<header>
\t\t\t<h1>Prodavnica Čajeva</h1>
\t\t\t<nav>
\t\t\t\t<ul>
\t\t\t\t\t<li><a href=\"index.php\">Početna</a></li>
\t\t\t\t\t<li><a href=\"/teas\">Čajevi</a></li>
\t\t\t\t\t<li><a href=\"/cart\">Korpa</a></li>
\t\t\t\t\t<li><a href=\"/login\">Prijava</a></li>
\t\t\t\t\t<li><a href=\"/register\">Registracija</a></li>
\t\t\t\t</ul>
\t\t\t</nav>
\t\t</header>

\t\t<main>
\t\t\t";
        // line 24
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 25
        yield "\t\t</main>

\t\t<footer>
\t\t\t<p>&copy;
\t\t\t\t";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "
\t\t\t\tProdavnica Čajeva.</p>
\t\t</footer>
\t</body>
</html>
";
        yield from [];
    }

    // line 24
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.html.twig";
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
        return array (  90 => 24,  79 => 29,  73 => 25,  71 => 24,  50 => 6,  43 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "base.html.twig", "C:\\wamp64\\www\\project\\app\\Views\\base.html.twig");
    }
}
