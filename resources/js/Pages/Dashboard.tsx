// @ts-ignore
import { Head } from '@inertiajs/react';
import React, { useState } from "react";
import { router } from "@inertiajs/react";

export default function Dashboard({ auth, games }) {
  const [gameName, setGameName] = useState(''); // State to store the game name
  const [showModal, setShowModal] = useState(false); // State to show/hide the modal
  const [renameGameId, setRenameGameId] = useState(null); // State to store the game ID for renaming

  const openModal = () => setShowModal(true);
  const closeModal = () => {
    setShowModal(false);
    setRenameGameId(null);
  };

  const deleteGame = (game_id: number) => {
    router.delete(`dashboard/removeGame/${game_id}`);
  };

  // Handle game creation
  const handleNewGame = async () => {
    closeModal();

    if (!gameName) {
      console.error("Please enter a game name");
      return;
    }

    router.post('/game', {
      user_id: auth.id,
      name: gameName
    }, {
      onSuccess: () => {
        router.reload({ only: ['Dashboard'] });
      },
    });
  };

  const handleRenameGame = (game_id: number) => {
    setRenameGameId(game_id);
    const gameToRename = games.find((game) => game.id === game_id);
    if (gameToRename) {
      setGameName(gameToRename.name);
    }
  };


  const saveRenamedGame = async () => {
    try {
      // Send a PATCH request to update the game name
      router.patch(`/game/${renameGameId}/renameGame`, { name: gameName }, {
        onSuccess: () => {
          games.forEach((game) => {
            if (game.id === renameGameId) {
              game.name = gameName;
            }
          });
          setRenameGameId(null);
          setGameName('');
          router.reload({ only: ['Dashboard'] });
        },
      });
    } catch (error) {
      console.error('Failed to rename the game', error);
      // Handle the error (e.g., show an error message to the user)
    }
  };
 

  return (
    <div className="bg-black text-green min-h-screen p-4">
      <Head title="Dashboard" />

      <h1 className="text-4xl font-semibold mb-8">Algae Farmer Tycoon</h1>

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white rounded-lg shadow-lg p-6">
            <div>Hello, {auth.name}</div>

            <h2 className="text-2xl mt-4 mb-2">Your Games</h2>
            {games.length ? (
              <ul className="list-disc pl-4">
                {games.map((game) => (
                  <li key={game.id} className="mb-4">
                    <div className="flex items-center justify-between">
                      <a href={`/game/${game.id}`} className="text-green-600 hover:underline">
                        {renameGameId === game.id ? (
                          <input
                            type="text"
                            value={gameName}
                            onChange={(e) => setGameName(e.target.value)}
                            className="bg-green-700 text-green border rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                          />
                        ) : (
                          game.name
                        )}
                      </a>
                      <div>
                        {renameGameId === game.id ? (
                          <>
                            <button
                              onClick={(e) => saveRenamedGame()}
                              className="bg-green-600 hover:bg-green-700 text-green py-1 px-2 rounded-md ml-2"
                            >
                              Save
                            </button>
                            <button
                              onClick={closeModal}
                              className="bg-red-600 hover:bg-red-700 text-green py-1 px-2 rounded-md ml-2"
                            >
                              Cancel
                            </button>
                          </>
                        ) : (
                          // If not in rename mode, show "Rename" and "Delete" buttons
                          <>
                            <button
                              onClick={() => handleRenameGame(game.id)}
                              className="bg-blue hover:bg-blue text-green py-1 px-2 rounded-md ml-2"
                            >
                              Rename
                            </button>
                            <button
                              onClick={() => deleteGame(game.id)}
                              className="bg-red hover:bg-red text-green py-1 px-2 rounded-md ml-2"
                            >
                              Delete
                            </button>
                          </>
                        )}
                      </div>
                    </div>
                  </li>
                ))}
              </ul>
            ) : (
              <div>No games available. Start a new game below!</div>
            )}

            <button
              onClick={openModal}
              className="bg-green-600 hover:bg-green-700 text-green py-2 px-4 rounded-md mt-4"
            >
              Start New Game
            </button>

            {/* Modal for game name */}
            {showModal && (
              <div className="bg-green-800 text-white p-4 mt-4 rounded-lg">
                <div className="mb-2">Please enter a game name:</div>
                <input
                  type="text"
                  value={gameName}
                  onChange={e => setGameName(e.target.value)}
                  className="bg-green-700 text-white border rounded-md py-1 px-2 focus:outline-none focus:ring-2 focus:ring-green-600"
                />
                <button
                  onClick={handleNewGame}
                  className="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md ml-2"
                >
                  Confirm
                </button>
                <button
                  onClick={closeModal}
                  className="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md ml-2"
                >
                  Cancel
                </button>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}
