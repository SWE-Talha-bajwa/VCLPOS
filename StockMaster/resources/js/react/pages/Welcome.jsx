import React from 'react';
import Logo from '../components/Logo';

export default function Welcome() {
    return (
        <div className="min-h-screen flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-900">
            <div className="mb-8">
                <Logo className="h-24 w-auto" />
            </div>
            <div className="text-center">
                <h1 className="text-4xl font-bold text-gray-900 dark:text-white mb-4">Welcome to StockMaster</h1>
                <p className="text-lg text-gray-600 dark:text-gray-400 mb-8">Advanced Point of Sale & Inventory Management</p>

                <div className="space-x-4">
                    <a href="/react/login" className="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Login</a>
                    <a href="/react/register" className="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Register</a>
                </div>
            </div>
        </div>
    );
}
