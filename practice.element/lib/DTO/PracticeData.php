<?php

namespace Practice\Element\DTO;

class PracticeData
{
    private string $name;
    private string $code;
    private int $iblockSectionId;
    private string $previewText;
    private string $previewPicture;
    private string $iblockId;
    private string $detailText;
    private string $detailPicture;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getIblockSectionId(): int
    {
        return $this->iblockSectionId;
    }

    public function setIblockSectionId(int $iblockSectionId): void
    {
        $this->iblockSectionId = $iblockSectionId;
    }

    public function getPreviewText(): string
    {
        return $this->previewText;
    }

    public function setPreviewText(string $previewText): void
    {
        $this->previewText = $previewText;
    }

    public function getIblockId(): string
    {
        return $this->iblockId;
    }

    public function setIblockId(string $iblockId): void
    {
        $this->iblockId = $iblockId;
    }

    public function getDetailText(): string
    {
        return $this->detailText;
    }

    public function setDetailText(string $detailText): void
    {
        $this->detailText = $detailText;
    }

    public function getDetailPicture(): string
    {
        return $this->detailPicture;
    }

    public function setDetailPicture(string $detailPicture): void
    {
        $this->detailPicture = $detailPicture;
    }

    public function getPreviewPicture(): string
    {
        return $this->previewPicture;
    }

    public function setPreviewPicture(string $previewPicture): void
    {
        $this->previewPicture = $previewPicture;
    }
}
