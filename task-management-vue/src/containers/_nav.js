export default [
  {
    _name: 'CSidebarNav',
    _children: [
      {
        _name: 'CSidebarNavTitle',
        _children: ['Tasks']
      },
      {
        _name: 'CSidebarNavItem',
        name: 'Assigned Tasks',
        to: '/assigned-tasks',
        icon: 'cil-pin'
      },
      {
        _name: 'CSidebarNavItem',
        name: 'My Tasks',
        to: '/my-tasks',
        icon: 'cil-list'
      }
    ]
  }
]