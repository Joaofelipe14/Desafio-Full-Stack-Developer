export  function getInitials(name: string) {
    const names = name.split(" ");
    const initials = names.map(part => part.charAt(0).toUpperCase()).join("");
    return initials.slice(0, 2);
}