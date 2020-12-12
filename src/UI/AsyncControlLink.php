<?php declare(strict_types = 1);

namespace Pd\AsyncControl\UI;

final class AsyncControlLink
{

	private static string $defaultMessage = 'Load content';
	private static array $defaultAttributes = [];

	private string $message;

	/** @var mixed[] */
	private array $attributes;

	/**
	 * @param string|null $message
	 * @param mixed[]|null $attributes
	 */
	public function __construct(
		?string $message = null,
		?array $attributes = null
	) {
		$this->message = $message ?? self::$defaultMessage;
		$this->attributes = $attributes ?? self::$defaultAttributes;
	}

	/**
	 * @param string $message
	 * @param mixed[] $attributes
	 */
	public static function setDefault(string $message, array $attributes = []): void
	{
		self::$defaultMessage = $message;
		self::$defaultAttributes = $attributes;
	}

	public function getMessage(): string
	{
		return $this->message;
	}

	/** @return mixed[] */
	public function getAttributes(): array
	{
		return $this->attributes;
	}

}
