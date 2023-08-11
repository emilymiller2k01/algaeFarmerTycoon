import React from 'react'
import '../../css/app.css'
//import { InertiaLink } from '@inertiajs/inertia-react';

const Landing = ({ auth }) => {
    return (
        <div>
            <h1>Welcome to Our App!</h1>

            {auth.user ? (
                <div>
                    <p>Welcome back, {auth.user.name}!</p>
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

export default Landing;
