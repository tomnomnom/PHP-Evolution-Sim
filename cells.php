<?php
define('TARGET', 'METHINKS IT IS LIKE A WEASEL');
define('MUTATION_CHANCE', 0.05);

// The lower, the better!
function fitness($organism, $target){
  return levenshtein($organism, $target);
}

function divide($organism, $mutationChance){
  $organism = str_split($organism);
  $mutationChance = intval(1/$mutationChance);

  $newOrganism = '';
  foreach ($organism as $gene){
    if (rand(0, $mutationChance) == 0){
      $gene = randomGene();
    }
    $newOrganism .= $gene; 
  }
  return $newOrganism;
}

function randomGene(){
  static $possibleGenes;
  if (!isset($possibleGenes)){
    $possibleGenes = array_merge(range('A', 'Z'), array(' '));
  }
  return $possibleGenes[array_rand($possibleGenes)];
}

// Initial organism
$eliteOrganism = '';
for ($i = 0; $i < strLen(TARGET); $i++){
  $eliteOrganism .= randomGene();
}
echo "Starting with intial organism: {$eliteOrganism}\n";

$generation = 0;
while ($eliteFitness = fitness($eliteOrganism, TARGET)){
  $generation++;

  $newOrganism = divide($eliteOrganism, MUTATION_CHANCE);
  $newFitness = fitness($newOrganism, TARGET);

  if (($newFitness < $eliteFitness) || 
      ($newFitness == $eliteFitness && rand(0, 1))
  ){
    $eliteOrganism = $newOrganism;
  } 

  if (!($generation % 100)){
    echo "New elite organism (generation {$generation}): {$eliteOrganism}\n";
  }
}
echo "Met target at generation {$generation}: {$eliteOrganism}\n";



