import React, { useState } from 'react';
import API_ROUTES from '../config/api';
import GuestLayout from '../components/GuestLayout';

export default function Register() {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('Register attempt to:', API_ROUTES.REGISTER);
    };

    return (
        <GuestLayout>
            <form onSubmit={handleSubmit}>
                {/* Name */}
                <div>
                    <label htmlFor="name" className="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Name
                    </label>
                    <input
                        id="name"
                        type="text"
                        className="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        required
                        autoFocus
                        autoComplete="name"
                    />
                </div>

                {/* Email */}
                <div className="mt-4">
                    <label htmlFor="email" className="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        className="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                        autoComplete="username"
                    />
                </div>

                {/* Password */}
                <div className="mt-4">
                    <label htmlFor="password" className="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        className="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                        autoComplete="new-password"
                    />
                </div>

                {/* Confirm Password */}
                <div className="mt-4">
                    <label htmlFor="password_confirmation" className="block font-medium text-sm text-gray-700 dark:text-gray-300">
                        Confirm Password
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        className="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full"
                        value={passwordConfirmation}
                        onChange={(e) => setPasswordConfirmation(e.target.value)}
                        required
                        autoComplete="new-password"
                    />
                </div>

                <div className="flex items-center justify-end mt-4">
                    <a
                        href="/react/login"
                        className="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Already registered?
                    </a>

                    <button
                        type="submit"
                        className="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ms-3"
                    >
                        Register
                    </button>
                </div>
            </form>
        </GuestLayout>
    );
}
