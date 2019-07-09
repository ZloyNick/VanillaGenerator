<?php

declare(strict_types=1);

namespace muqsit\vanillagenerator\generator\overworld\populator;

use muqsit\vanillagenerator\generator\overworld\biome\BiomeIds;
use muqsit\vanillagenerator\generator\overworld\populator\biome\BiomePopulator;
use muqsit\vanillagenerator\generator\overworld\populator\biome\PlainsPopulator;
use muqsit\vanillagenerator\generator\Populator;
use pocketmine\utils\Random;
use pocketmine\world\ChunkManager;
use pocketmine\world\format\Chunk;
use ReflectionClass;

class OverworldPopulator implements Populator{

	/** @var Populator[] */
	private $biomePopulators = []; // key = biomeId

	/**
	 * Creates a populator with biome populators for all vanilla overworld biomes.
	 */
	public function __construct(){
		$this->registerBiomePopulator(new BiomePopulator()); // defaults applied to all biomes
		$this->registerBiomePopulator(new PlainsPopulator());
		/*
		$this->registerBiomePopulator(new SunflowerPlainsPopulator());
		$this->registerBiomePopulator(new ForestPopulator());
		$this->registerBiomePopulator(new BirchForestPopulator());
		$this->registerBiomePopulator(new BirchForestMountainsPopulator());
		$this->registerBiomePopulator(new RoofedForestPopulator());
		$this->registerBiomePopulator(new FlowerForestPopulator());
		$this->registerBiomePopulator(new DesertPopulator());
		$this->registerBiomePopulator(new DesertMountainsPopulator());
		$this->registerBiomePopulator(new JunglePopulator());
		$this->registerBiomePopulator(new JungleEdgePopulator());
		$this->registerBiomePopulator(new SwamplandPopulator());
		$this->registerBiomePopulator(new TaigaPopulator());
		$this->registerBiomePopulator(new MegaTaigaPopulator());
		$this->registerBiomePopulator(new MegaSpruceTaigaPopulator());
		$this->registerBiomePopulator(new IcePlainsPopulator());
		$this->registerBiomePopulator(new IcePlainsSpikesPopulator());
		$this->registerBiomePopulator(new SavannaPopulator());
		$this->registerBiomePopulator(new SavannaMountainsPopulator());
		$this->registerBiomePopulator(new ExtremeHillsPopulator());
		$this->registerBiomePopulator(new ExtremeHillsPlusPopulator());
		$this->registerBiomePopulator(new MesaPopulator());
		$this->registerBiomePopulator(new MesaForestPopulator());
		$this->registerBiomePopulator(new MushroomIslandPopulator());
		$this->registerBiomePopulator(new OceanPopulator());
		*/
	}

	public function populate(ChunkManager $world, Random $random, Chunk $chunk) : void{
		$biome = $chunk->getBiomeId(8, 8);
		if(isset($this->biomePopulators[$biome])){
			$this->biomePopulators[$biome]->populate($world, $random, $chunk);
		}
	}

	private function registerBiomePopulator(BiomePopulator $populator) : void{
		$biomes = $populator->getBiomes();
		if($biomes === null){
			$biomes = array_values((new ReflectionClass(BiomeIds::class))->getConstants());
		}

		foreach($biomes as $biome){
			$this->biomePopulators[$biome] = $populator;
		}
	}
}