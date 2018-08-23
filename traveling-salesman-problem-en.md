Traveling Salesman Problem 
========================

The Problem
-----------
You are a successful salesman working for a big company. You have 32 big accounts around the globe to visit on a periodic basis, and you have been assigned the project of saving money on your already dilated travel expense allowance. Given a list of your companies GPS locations, write a script that will help you find the shortest path to visit all 32 places once.


Input file specifications
-----------
The input file will contain a listing of cities and coordinates in a tab-delimited file.
The filename is named exactly "cities.txt".
Your script will assume this file is located on the same directory where the script is executed.
There are no additional spaces or lines at the beginning or end of the file.
The list will being in "Beijing", you must begin your route there.

An example input file:
```
Beijing 39.93 116.40
Vladivostok 43.8 131.54
Dakar 14.40 -17.28
Singapore 1.14 103.55
(...)
```

Script and Runtime Specifications
-----------
The maximum execution time is 15 minutes.

Your script's final (and only) output will be using any standard output function.
Do not attempt to write to disk, only print to screen.
The output must consist of a list of the 32 original cities provided in the input file "cities.txt".
These 32 cities should be ordered in the exact order in which you will visit your friends.
There must be only one city name (exact spelling) per line followed by a newline delimiter (\n)
You will be judged on the total distance covered in your travels, the shorter the better.
You cannot visit a city twice, and you must visit all cities.

An example output:
```
Beijing
Vladivostok
Dakar
Singapore
(...)
```

Notes
-----------
TSP ("Traveling Salesman Problem") is an NP-hard problem in combinatorial optimization; it is possible that the worst-case running time for any algorithm for the TSP increases superpolynomially (but no more than exponentially) with the number of cities.
### Direct solution ###
The most direct solution would be using brute force search, calculating all possible paths and determining which one is the cheapest. The running time for this approach lies within a polynomial factor of O(n!), the factorial of the number of cities, so this solution becomes impractical even for only 20 cities.
### Sub-Optimal solutions ###
A Sub-Optimal solution can come from heuristic algorithms, that deliver either seemingly or probably good solutions, but which could not be proved to be optimal. 
#### Nearest Neighbour ####
Some are pretty simple, like the 'Nearest Neighbour', that lets the salesman choose the nearest unvisited city as his next move; this algorithm quickly yields an effectively short route: for N cities randomly distributed on a plane, the algorithm on average yields a path 25% longer than the shortest possible path. 
#### Anto Colony System ####
Other heuristic algorithms are more complex, but they give better solutions: one example is 'ACS' (ant colony system), that sends out a large number of virtual ant agents to explore many possible routes on the map; each ant probabilistically chooses the next city to visit based on a heuristic combining the distance to the city and the amount of virtual pheromone deposited on the edge to the city. The ants explore, depositing pheromone on each edge that they cross, until they have all completed a tour. At this point the ant which completed the shortest tour deposits virtual pheromone along its complete tour route (global trail updating). The amount of pheromone deposited is inversely proportional to the tour length: the shorter the tour, the more it deposits.
#### Simulated annealing ####
Another heuristic algorithm that can be used for solving TSP is "Simulated Annealing",  that is a metaheuristic to approximate global optimization in a large search space. The name and inspiration come from annealing in metallurgy, a technique involving heating and controlled cooling of a material to increase the size of its crystals and reduce their defects. This notion of slow cooling implemented in the simulated annealing algorithm is interpreted as a slow decrease in the probability of accepting worse solutions as the solution space is explored. At each time step, the algorithm randomly selects a solution close to the current one, measures its quality, and then decides to move to it or to stay with the current solution based on either one of two probabilities between which it chooses on the basis of the fact that the new solution is better or worse than the current one. During the search, the temperature is progressively decreased from an initial positive value to zero and affects the two probabilities: at each step, the probability of moving to a better new solution is either kept to 1 or is changed towards a positive value; instead, the probability of moving to a worse new solution is progressively changed towards zero. In the travelling salesman problem each state is typically defined as a permutation of the cities to be visited, and its neighbours are the set of permutations produced by reversing the order of any two successive cities.

Assumptions
-----------
- This is a symmetric graph, hence the distance between two cities is the same in each opposite direction (a --> b === b --> a); this means I can calculate the distance of only half the matrix, the other half can be mirrored on the diagonal.
```
| / | a | b | c | d | e |
| a | 0 |   |   |   |   |
| b |   | 0 |   |   |   |
| c |   |   | 0 |   |   |
| d |   |   |   | 0 |   |
| e |   |   |   |   | 0 |
```
