import React from 'react';

const Link = ({ href, className, children, ...props }) => {
    const handleClick = (e) => {
        e.preventDefault();
        window.history.pushState({}, '', href);
        // Dispatch custom event to notify App.jsx
        window.dispatchEvent(new Event('pushstate'));
    };

    return (
        <a href={href} className={className} onClick={handleClick} {...props}>
            {children}
        </a>
    );
};

export default Link;
