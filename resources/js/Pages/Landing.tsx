import '../../css/app.css'
import React, { useState } from "react";
import {router} from "@inertiajs/react";
import { PageProps } from '../types';
import { GameProps } from './Game';

const Landing = ({ auth, games }: PageProps<LandingProps>) => {
    
    const [gameName, setGameName] = useState(''); // State to store the game name
    const [showModal, setShowModal] = useState(false); // State to show/hide the modal

    const openModal = () => setShowModal(true);
    const closeModal = () => setShowModal(false);

    // Handle game creation
    const handleNewGame = async () => {
        closeModal();

        if (!gameName) {
            console.error("Please enter a game name");
            return; // exit the function if no game name is provided
        }


        router.post('/game', {
            user_id: auth.user.id,
            name: gameName
        });


    };

    console.log(games);


    return (
        <div>
            <h1>Welcome to Our App!</h1>

            {auth?.user ? (
                <div>
                    <p>Welcome back, {auth.user.name}!</p>
                    <div className="p-6 text-gray-900">

                            <h3>Your Games</h3>
                            {games.length ? (
                                <ul>
                                    {games.map(game => (
                                        <li key={game.id}>
                                            <a href={`/game/${game.id}`}>{game.name}</a>
                                        </li>
                                    ))}
                                </ul>
                            ) : (
                                <div>No games available. Start a new game below!</div>
                            )}

                            <button onClick={openModal}>Start New Game</button>

                            {/* Modal for game name */}
                            {showModal && (
                                <div>
                                    <div>Please enter game name:</div>
                                    <input
                                        type="text"
                                        value={gameName}
                                        onChange={e => setGameName(e.target.value)}
                                    />
                                    <button onClick={handleNewGame}>Confirm</button>
                                    <button onClick={closeModal}>Cancel</button>
                                </div>
                            )} 
                        </div>
                </div>
            ) : (
                <div>
                    <p>You're not logged in.</p>
                    <a href="/login">Login</a> or <a href="/register">Register</a>
                </div>
            )}
        </div>
    );
};

export type LandingProps = {
    games: GameProps[];
}

export default Landing;
