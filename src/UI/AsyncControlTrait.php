<?php declare(strict_types = 1);

namespace Pd\AsyncControl\UI;

use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\Template;


/** @method render() */
trait AsyncControlTrait
{

	/** @var callable */
	protected $asyncRenderer;

	public function handleAsyncLoad(): void
	{
		if (!$this instanceof Control || !($presenter = $this->getPresenterIfExists()) || !$presenter->isAjax()) {
			return;
		}
		ob_start(function () {
		});

		try {
			$this->doRender();
		} catch (\Throwable $e) {
			ob_end_clean();
			throw $e;
		}

		$content = ob_get_clean();
		$presenter->getPayload()->snippets[$this->getSnippetId('async')] = $content;
		$presenter->sendPayload();
	}

	/**
	 * @param array<string, string> $linkAttributes
	 * @return void
	 */
	public function renderAsync(string $linkMessage = null, array $linkAttributes = null): void
	{
		$template = $this->createTemplate();

		if ($template instanceof Template) {
			$template->add('link', new AsyncControlLink($linkMessage, $linkAttributes));
		}

		$template->setFile(__DIR__ . '/templates/asyncLoadLink.latte');
		$template->render();
	}


	public function setAsyncRenderer(callable $renderer): void
	{
		$this->asyncRenderer = $renderer;
	}


	protected function doRender(): void
	{
		if (is_callable($this->asyncRenderer)) {
			call_user_func($this->asyncRenderer);
		} else {
			$this->render();
		}
	}
}
