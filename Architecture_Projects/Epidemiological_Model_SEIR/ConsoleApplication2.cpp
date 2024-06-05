// ConsoleApplication2.cpp : Ce fichier contient la fonction 'main'. L'exécution du programme commence et se termine à cet endroit.
#include <iostream>
#include <vector>
#include <cmath>
#include <random>
#include <fstream>
#include <algorithm>
#include <string>

const int TAILLE_GRILLE = 300;
const int NB_INDIVIDUS = 20000;
const int NB_INFECTES_INIT = 20;

double negExp(double inMean, std::mt19937& gen) {
    std::exponential_distribution<> distrib(1.0 / inMean);
    return distrib(gen);
}

enum Statut { S, E, I, R };

class Individu {
public:
    Statut statut;
    int tempsStatut;
    int dE, dI, dR;
    int posX, posY;

    Individu() : statut(S), tempsStatut(0), dE(0), dI(0), dR(0), posX(0), posY(0) {}

    void deplacer() {
        std::random_device rd;
        std::mt19937 gen(rd());
        std::uniform_int_distribution<> distrib(0, TAILLE_GRILLE - 1);

        posX = distrib(gen);
        posY = distrib(gen);
    }

    void miseAJourStatut() {
        switch (statut) {
        case E:
            if (++tempsStatut > dE) { statut = I; tempsStatut = 0; }
            break;
        case I:
            if (++tempsStatut > dI) { statut = R; tempsStatut = 0; }
            break;
        case R:
            if (++tempsStatut > dR) { statut = S; tempsStatut = 0; }
            break;
        default:
            break;
        }
    }
};

class Grille {
private:
    std::vector<Individu> individus;
    std::vector<std::vector<std::vector<int>>> cellules;
    std::ofstream file;

public:
    Grille() : cellules(TAILLE_GRILLE, std::vector<std::vector<int>>(TAILLE_GRILLE)) {}

    void initialiser(int num_simulation) {
        file.open("simulation_" + std::to_string(num_simulation) + ".csv");
        file << "S,E,I,R\n";

        std::random_device rd;
        std::mt19937 gen(rd());

        for (int i = 0; i < NB_INDIVIDUS; ++i) {
            Individu ind;
            ind.deplacer();

            ind.dE = static_cast<int>(negExp(3.0, gen));
            ind.dI = static_cast<int>(negExp(7.0, gen));
            ind.dR = static_cast<int>(negExp(365.0, gen));

            if (i < NB_INFECTES_INIT) {
                ind.statut = I;
            }

            individus.push_back(ind);
            cellules[ind.posX][ind.posY].push_back(i);
        }
    }

    void iteration(int jour) {
        for (int i = 0; i < individus.size(); ++i) {
            auto& ind = individus[i];
            auto& ancienneCellule = cellules[ind.posX][ind.posY];
            ancienneCellule.erase(std::remove(ancienneCellule.begin(), ancienneCellule.end(), i), ancienneCellule.end());

            ind.deplacer();
            cellules[ind.posX][ind.posY].push_back(i);

            ind.miseAJourStatut();
        }

        for (auto& ind : individus) {
            if (ind.statut == S) {
                int ni = compterInfectesVoisinage(ind.posX, ind.posY);
                double proba = 1 - exp(-0.5 * ni);

                std::random_device rd;
                std::mt19937 gen(rd());
                std::uniform_real_distribution<> distrib(0.0, 1.0);
                if (distrib(gen) < proba) {
                    ind.statut = E;
                }
            }
        }

        int nbS = 0, nbE = 0, nbI = 0, nbR = 0;
        for (const auto& ind : individus) {
            switch (ind.statut) {
            case S: nbS++; break;
            case E: nbE++; break;
            case I: nbI++; break;
            case R: nbR++; break;
            }
        }
        file  << nbS << "," << nbE << "," << nbI << "," << nbR << "\n";
    }

    int compterInfectesVoisinage(int x, int y) {
        int count = 0;
        for (int dx = -1; dx <= 1; dx++) {
            for (int dy = -1; dy <= 1; dy++) {
                int nx = (x + dx + TAILLE_GRILLE) % TAILLE_GRILLE;
                int ny = (y + dy + TAILLE_GRILLE) % TAILLE_GRILLE;

                for (auto idx : cellules[nx][ny]) {
                    if (individus[idx].statut == I) {
                        count++;
                    }
                }
            }
        }
        return count;
    }

    void fermerFichier() {
        file.close();
    }
};

int main() {
    for (int sim = 1; sim <= 100; sim++) {
        Grille grille;
        grille.initialiser(sim);

        for (int jour = 0; jour < 730; ++jour) {
            grille.iteration(jour);
        }

        grille.fermerFichier();
    }

    return 0;
}
