import React from 'react';

export default function Logo({ className = "h-20 w-auto" }) {
    return (
        <img
            src="/images/logo.png"
            alt="StockMaster Logo"
            className={className}
        />
    );
}
